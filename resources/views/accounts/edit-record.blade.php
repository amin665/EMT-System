@extends('layouts.app')

@section('header', 'تعديل السجل الطبي')

@section('content')
    <div class="card p-8 max-w-3xl mx-auto">
        <form action="{{ route('medical-records.update', $medicalRecord->id) }}" method="POST" enctype="multipart/form-data">
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
                    <label class="label">الادوية</label>
                    <input type="text" name="medicines" value="{{ $medicalRecord->medicines }}" class="input">
                </div>
                
                <div class="md:col-span-2">
                    <label class="label">ملاحظات المتابعة</label>
                    <textarea name="followUpNotes" class="textarea" rows="3">{{ $medicalRecord->followUpNotes }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="label">مرفق (صورة او PDF)</label>
                    <input type="file" name="attachment" class="input" accept="image/*,.pdf">
                    @if(!empty($medicalRecord->attachment_path))
                        <div class="mt-2">
                            <a href="{{ asset('storage/' . $medicalRecord->attachment_path) }}" class="link" target="_blank" rel="noopener">
                                عرض المرفق الحالي ({{ $medicalRecord->attachment_original_name }})
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex justify-start space-x-4 space-x-reverse mt-6">
                <button type="submit" class="btn btn-primary">تحديث السجل</button>
                <a href="{{ route('patients.show', $medicalRecord->patientID) }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection