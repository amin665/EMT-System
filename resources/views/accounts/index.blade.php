@extends('layouts.app')

@section('header', 'سجلات المرضى')

@section('content')
    <div class="card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="section-title">قائمة المرضى</h2>
        </div>

        <form method="GET" action="{{ route('patients.index') }}" class="mb-4">
            <div class="flex flex-col md:flex-row md:items-end gap-3">
                <div class="flex-1">
                    <label for="patient_name" class="label">اسم المريض</label>
                    <input
                        type="text"
                        id="patient_name"
                        name="patient_name"
                        value="{{ request('patient_name') }}"
                        placeholder="ابحث باسم المريض"
                        class="input"
                    />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                    @if(request()->filled('patient_name'))
                        <a href="{{ route('patients.index') }}" class="btn btn-outline">
                            مسح
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="overflow-x-auto rounded-lg border border-gray-800/60">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-right">الاسم</th>
                        <th class="text-right">الهاتف</th>
                        <th class="text-right">تاريخ الميلاد</th>
                        <th class="text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($patients as $patient)
                        <tr class="transition cursor-pointer" onclick="window.location='{{ route('patients.show', $patient->id) }}'">
                            <td class="text-sm font-medium text-gray-100">{{ $patient->fullName }}</td>
                            <td class="text-sm text-gray-400">{{ $patient->phoneNumber }}</td>
                            <td class="text-sm text-gray-400">{{ $patient->dob->format('Y-m-d') }}</td>
                            <td class="text-left space-x-3 space-x-reverse" onclick="event.stopPropagation()">
                                <a href="{{ route('patients.show', $patient->id) }}" class="link">عرض</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $patients->links('vendor.pagination.dark') }}
        </div>
    </div>
@endsection