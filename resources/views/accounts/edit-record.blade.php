@extends('layouts.app')

@section('content')
    <h2>Edit Medical Transcript</h2>
    <hr>
    
    <form action="{{ route('medical-records.update', $medicalRecord->id) }}" method="POST" class="card p-4">
        @csrf @method('PUT')
        
        <div class="mb-3">
            <label>Diagnosis</label>
            <input type="text" name="diagnosis" value="{{ $medicalRecord->diagnosis }}" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Prescription</label>
            <input type="text" name="prescription" value="{{ $medicalRecord->prescription }}" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Follow-up Notes</label>
            <textarea name="followUpNotes" class="form-control" rows="3">{{ $medicalRecord->followUpNotes }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Transcript</button>
        <a href="{{ route('patients.show', $medicalRecord->patientID) }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection