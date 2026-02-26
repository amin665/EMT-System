<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\AuditLog;
use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function store(StoreMedicalRecordRequest $request)
    {
        $data = $request->validated();
        $data['doctorID'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $data['attachment_path'] = $file->store('medical-records', 'public');
            $data['attachment_original_name'] = $file->getClientOriginalName();
            $data['attachment_mime'] = $file->getClientMimeType();
        }

        $record = MedicalRecord::create($data);

        // Audit Log
        AuditLog::create([
            'recordID' => $record->id,
            'performedBy' => auth()->id(),
            'actionType' => 'Created Record',
            'details' => 'Initial Diagnosis created.'
        ]);

        return redirect()->route('patients.show', $data['patientID'])
                         ->with('success', 'Medical record added successfully.');
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->doctorID !== auth()->id()) abort(403);
        return view('accounts.edit-record', compact('medicalRecord'));
    }

    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->doctorID !== auth()->id()) abort(403);
        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            if (!empty($medicalRecord->attachment_path)) {
                Storage::disk('public')->delete($medicalRecord->attachment_path);
            }

            $file = $request->file('attachment');
            $data['attachment_path'] = $file->store('medical-records', 'public');
            $data['attachment_original_name'] = $file->getClientOriginalName();
            $data['attachment_mime'] = $file->getClientMimeType();
        }

        $medicalRecord->update($data);

        // Audit Log
        AuditLog::create([
            'recordID' => $medicalRecord->id,
            'performedBy' => auth()->id(),
            'actionType' => 'Updated Record',
            'details' => 'Diagnosis/Prescription updated.'
        ]);

        return redirect()->route('patients.show', $medicalRecord->patientID)
                         ->with('success', 'Medical record updated successfully.');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->doctorID !== auth()->id()) abort(403);
        
        $patientID = $medicalRecord->patientID;

        if (!empty($medicalRecord->attachment_path)) {
            Storage::disk('public')->delete($medicalRecord->attachment_path);
        }

        $medicalRecord->delete();

        // Audit Log (Record ID is null in table for deleted, but we log the event)
        AuditLog::create([
            'recordID' => null, 
            'performedBy' => auth()->id(),
            'actionType' => 'Deleted Record',
            'details' => "Deleted record ID: {$medicalRecord->id}"
        ]);

        return redirect()->route('patients.show', $patientID)
                         ->with('success', 'Medical record deleted successfully.');
    }
}