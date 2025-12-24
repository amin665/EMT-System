@extends('layouts.app')

@section('header', 'سجلات المرضى')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">قائمة المرضى</h2>
            <a href="{{ route('patients.create') }}" class="bg-primary text-white py-2 px-4 rounded-lg font-medium hover:bg-green-600 transition shadow-md">
                + إضافة مريض جديد
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الاسم</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الهاتف</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">تاريخ الميلاد</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($patients as $patient)
                        <tr class="hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('patients.show', $patient->id) }}'">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $patient->fullName }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->phoneNumber }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $patient->dob->format('Y-m-d') }}</td>
                            <td class="px-6 py-4 text-left space-x-2 space-x-reverse" onclick="event.stopPropagation()">
                                <a href="{{ route('patients.show', $patient->id) }}" class="text-accent hover:underline">عرض</a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="text-yellow-500 hover:underline">تعديل</a>
                                <form id="delete-patient-{{ $patient->id }}" action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="text-danger hover:underline" onclick="confirmDelete('delete-patient-{{ $patient->id }}')">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection