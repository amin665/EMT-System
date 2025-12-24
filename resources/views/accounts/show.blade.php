@extends('layouts.app')

@section('header', 'ملف المريض')

@section('content')
    <a href="{{ route('patients.index') }}" class="text-accent hover:underline mb-4 inline-block">&larr; العودة للقائمة</a>

    <!-- Patient Details -->
    <div class="bg-white p-6 rounded-xl shadow-lg mb-6 border-r-4 border-accent">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $patient->fullName }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
            <p><strong>الهاتف:</strong> {{ $patient->phoneNumber }}</p>
            <p><strong>تاريخ الميلاد:</strong> {{ $patient->dob->format('Y-m-d') }}</p>
            <div class="col-span-2 bg-gray-50 p-3 rounded">
                <strong>التاريخ الطبي:</strong> {{ $patient->medicalHistory ?? 'لا يوجد' }}
            </div>
        </div>
    </div>

    <!-- Medical Records Section -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-800">السجلات الطبية</h3>
        <button onclick="document.getElementById('addRecordForm').classList.toggle('hidden')" class="bg-primary text-white py-1 px-4 rounded shadow hover:bg-green-600 transition">
            + إضافة سجل جديد
        </button>
    </div>

    <!-- Add Form (Hidden by default) -->
    <div id="addRecordForm" class="hidden bg-white p-6 rounded-xl shadow-lg mb-6 border border-gray-200">
        <form action="{{ route('medical-records.store-for-patient', $patient->id) }}" method="POST">
            @csrf
            <input type="hidden" name="patientID" value="{{ $patient->id }}">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm text-gray-700">التشخيص</label>
                    <input type="text" name="diagnosis" class="w-full p-2 border rounded" required>
                </div>
                <div>
                    <label class="block text-sm text-gray-700">الوصفة الطبية</label>
                    <input type="text" name="prescription" class="w-full p-2 border rounded" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm text-gray-700">ملاحظات</label>
                    <textarea name="followUpNotes" class="w-full p-2 border rounded"></textarea>
                </div>
            </div>
            <button type="submit" class="bg-accent text-white py-2 px-4 rounded hover:bg-blue-600">حفظ السجل</button>
        </form>
    </div>

    <!-- Records Timeline -->
    <div class="space-y-4">
        @forelse($patient->medicalRecords->sortByDesc('created_at') as $record)
            <div class="bg-white p-6 rounded-xl shadow border-r-4 border-gray-300 relative">
                <div class="flex justify-between">
                    <span class="text-gray-500 text-sm">{{ $record->created_at->format('Y-m-d H:i') }}</span>
                    <div class="space-x-2 space-x-reverse">
                        <a href="{{ route('medical-records.edit', $record->id) }}" class="text-yellow-600 hover:underline text-sm">تعديل</a>
                        <form id="delete-record-{{ $record->id }}" action="{{ route('medical-records.destroy', $record->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" class="text-danger hover:underline text-sm" onclick="confirmDelete('delete-record-{{ $record->id }}')">حذف</button>
                        </form>
                    </div>
                </div>
                <h4 class="font-bold text-lg mt-2">{{ $record->diagnosis }}</h4>
                <p class="text-gray-700 mb-2"><strong>Rx:</strong> {{ $record->prescription }}</p>
                <p class="text-gray-500 text-sm bg-gray-50 p-2 rounded">{{ $record->followUpNotes }}</p>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">لا توجد سجلات طبية.</p>
        @endforelse
    </div>
@endsection