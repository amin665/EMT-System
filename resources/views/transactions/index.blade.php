@extends('layouts.app')

@section('header', 'إدارة المواعيد')

@section('content')
    <div class="card p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="section-title">جدول المواعيد</h2>
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                + موعد جديد
            </a>
        </div>

        <form method="GET" action="{{ route('appointments.index') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 md:items-end">
                <div>
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
                <div>
                    <label for="date" class="label">التاريخ</label>
                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ request('date') }}"
                        class="input"
                    />
                </div>
                <div>
                    <label for="time" class="label">الوقت</label>
                    <input
                        type="time"
                        id="time"
                        name="time"
                        value="{{ request('time') }}"
                        class="input"
                    />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        بحث
                    </button>
                    @if(request()->filled('patient_name') || request()->filled('date') || request()->filled('time'))
                        <a href="{{ route('appointments.index') }}" class="btn btn-outline">
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
                        <th class="text-right">الوقت</th>
                        <th class="text-right">المريض</th>
                        <th class="text-right">الحالة</th>
                        <th class="text-left">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $apt)
                        @php
                            $statusClass = match($apt->status) {
                                'Scheduled' => 'badge-info',
                                'Done' => 'badge-success',
                                'Canceled' => 'badge-danger',
                                'Delayed' => 'badge-warning',
                                default => 'badge-neutral',
                            };
                        @endphp
                        <tr>
                            <td class="text-sm font-medium text-gray-100">{{ $apt->date->format('Y-m-d H:i') }}</td>
                            <td class="text-sm text-gray-400">{{ $apt->patient->fullName }}</td>
                            <td>
                                <span class="badge {{ $statusClass }}">{{ $apt->status }}</span>
                            </td>
                            <td class="text-left space-x-3 space-x-reverse">
                                <a href="{{ route('appointments.edit', $apt->id) }}" class="link">تعديل</a>
                                @if($apt->status != 'Canceled')
                                    <form id="cancel-apt-{{ $apt->id }}" action="{{ route('appointments.destroy', $apt->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="link link-danger" onclick="confirmDelete('cancel-apt-{{ $apt->id }}')">إلغاء</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $appointments->links('vendor.pagination.dark') }}
        </div>
    </div>
@endsection