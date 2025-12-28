<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\AuditLog;
use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;

class MedicalRecordController extends Controller
{
    public function store(StoreMedicalRecordRequest $request)
    {
        $data = $request->validated();
        $data['doctorID'] = auth()->id();

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

        $medicalRecord->update($request->validated());

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