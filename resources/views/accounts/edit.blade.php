@extends('layouts.app')

@section('content')
    <h2>Edit Patient</h2>
    <hr>
    
    <form action="{{ route('patients.update', $patient->id) }}" method="POST" class="card p-4">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="fullName" value="{{ $patient->fullName }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" name="phoneNumber" value="{{ $patient->phoneNumber }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" name="dob" value="{{ $patient->dob->format('Y-m-d') }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Medical History</label>
            <textarea name="medicalHistory" class="form-control" rows="3">{{ $patient->medicalHistory }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Patient</button>
        <a href="{{ route('patients.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection