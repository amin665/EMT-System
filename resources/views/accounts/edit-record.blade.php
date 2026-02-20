@extends('layouts.app')

@section('header', 'تعديل السجل الطبي')

@section('content')
    <div class="card p-8 max-w-3xl mx-auto">
        <form action="{{ route('medical-records.update', $medicalRecord->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label">التشخيص</label>
                    <input type="text" name="diagnosis" value="{{ $medicalRecord->diagnosis }}" class="input" required>
                </div>
                
                <div>
                    <label class="label">الوصفة الطبية</label>
                    <input type="text" name="prescription" value="{{ $medicalRecord->prescription }}" class="input" required>
                </div>
                
                <div class="md:col-span-2">
                    <label class="label">ملاحظات المتابعة</label>
                    <textarea name="followUpNotes" class="textarea" rows="3">{{ $medicalRecord->followUpNotes }}</textarea>
                </div>
            </div>

            <div class="flex justify-start space-x-4 space-x-reverse mt-6">
                <button type="submit" class="btn btn-primary">تحديث السجل</button>
                <a href="{{ route('patients.show', $medicalRecord->patientID) }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection