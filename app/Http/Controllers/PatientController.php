<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $patientsQuery = Patient::where('createdBy', auth()->id());

        if ($request->filled('patient_name')) {
            $name = trim($request->query('patient_name'));
            $patientsQuery->where('fullName', 'like', '%' . $name . '%');
        }

        $patients = $patientsQuery->orderBy('fullName')->paginate(10)->withQueryString();

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => $patients,
            ], 200);
        }

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
        $patient = Patient::create($data);

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 201,
                'data' => $patient,
            ], 201);
        }

        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Request $request, Patient $patient)
    {
        if ($patient->createdBy !== auth()->id()) abort(403);
        $patient->load('medicalRecords');

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => $patient,
            ], 200);
        }

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

        if ($request->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => $patient->fresh(),
            ], 200);
        }

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        if ($patient->createdBy !== auth()->id()) abort(403);
        $patient->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'status_code' => 200,
                'data' => 'Patient deleted successfully.',
            ], 200);
        }

        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}