@extends('layouts.app')

@section('header', 'ملف المريض')

@section('content')
    <a href="{{ route('patients.index') }}" class="link mb-4 inline-block">&larr; العودة للقائمة</a>

    <!-- Patient Details -->
    <div class="card p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-100 mb-2">{{ $patient->fullName }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
            <p><strong>الهاتف:</strong> {{ $patient->phoneNumber }}</p>
            <p><strong>تاريخ الميلاد:</strong> {{ $patient->dob->format('Y-m-d') }}</p>
            <div class="col-span-2 card-muted p-3 rounded-lg">
                <strong>التاريخ الطبي:</strong> {{ $patient->medicalHistory ?? 'لا يوجد' }}
            </div>
        </div>
    </div>

    <!-- Medical Records Section -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="section-title">السجلات الطبية</h3>
        <button onclick="document.getElementById('addRecordForm').classList.toggle('hidden')" class="btn btn-primary">
            + إضافة سجل جديد
        </button>
    </div>

    <!-- Add Form (Hidden by default) -->
    <div id="addRecordForm" class="hidden card p-6 mb-6">
        <form action="{{ route('medical-records.store-for-patient', $patient->id) }}" method="POST">
            @csrf
            <input type="hidden" name="patientID" value="{{ $patient->id }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="label">التشخيص</label>
                    <input type="text" name="diagnosis" class="input" required>
                </div>
                <div>
                    <label class="label">الوصفة الطبية</label>
                    <input type="text" name="prescription" class="input" required>
                </div>
                <div class="md:col-span-2">
                    <label class="label">الادوية</label>
                    <input type="text" name="medicines" class="input">
                </div>
                <div class="md:col-span-2">
                    <label class="label">ملاحظات</label>
                    <textarea name="followUpNotes" class="textarea"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">حفظ السجل</button>
        </form>
    </div>

    <!-- Records Timeline -->
    <div class="space-y-4">
        @forelse($patient->medicalRecords->sortByDesc('created_at') as $record)
            <div class="card p-6 relative">
                <div class="flex justify-between">
                    <span class="text-gray-400 text-sm">{{ $record->created_at->format('Y-m-d H:i') }}</span>
                    <div class="space-x-2 space-x-reverse">
                        <a href="{{ route('medical-records.edit', $record->id) }}" class="link text-sm">تعديل</a>
                        <form id="delete-record-{{ $record->id }}" action="{{ route('medical-records.destroy', $record->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" class="link link-danger text-sm" onclick="confirmDelete('delete-record-{{ $record->id }}')">حذف</button>
                        </form>
                    </div>
                </div>
                <h4 class="font-bold text-lg mt-2 text-gray-100">{{ $record->diagnosis }}</h4>
                <p class="text-gray-300 mb-2"><strong>Rx:</strong> {{ $record->prescription }}</p>
                @if(!empty($record->medicines))
                    <p class="text-gray-300 mb-2"><strong>الادوية:</strong> {{ $record->medicines }}</p>
                @endif
                <p class="text-gray-400 text-sm card-muted p-2 rounded">{{ $record->followUpNotes }}</p>
            </div>
        @empty
            <p class="text-gray-400 text-center py-4">لا توجد سجلات طبية.</p>
        @endforelse
    </div>
@endsection