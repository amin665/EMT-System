<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::where('createdBy', auth()->id())->get();
        // CHANGED: patients.index -> accounts.index
        return view('accounts.index', compact('patients'));
    }

    public function create()
    {
        // CHANGED: patients.create -> accounts.create
        return view('accounts.create');
    }

    public function store(StorePatientRequest $request)
    {
        $data = $request->validated();
        $data['createdBy'] = auth()->id();
        Patient::create($data);
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        if ($patient->createdBy !== auth()->id()) abort(403);
        $patient->load('medicalRecords');
        // CHANGED: patients.show -> accounts.show
        return view('accounts.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        if ($patient->createdBy !== auth()->id()) abort(403);
        // CHANGED: patients.edit -> accounts.edit
        return view('accounts.edit', compact('patient'));
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        if ($patient->createdBy !== auth()->id()) abort(403);
        $patient->update($request->validated());
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        if ($patient->createdBy !== auth()->id()) abort(403);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}