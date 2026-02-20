@extends('layouts.app')

@section('header', 'لوحة التحكم')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="card p-6 animate-fade" style="animation-delay: 80ms;">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-400">إجمالي المرضى</p>
                    <p class="text-3xl font-bold text-gray-100 mt-2">{{ $totalPatients }}</p>
                    <a href="{{ route('patients.index') }}" class="link text-sm mt-3 inline-flex">عرض الحسابات &larr;</a>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-rose-500/15 text-rose-300 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
        </div>

        <div class="card p-6 animate-fade" style="animation-delay: 160ms;">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm text-gray-400">مواعيد اليوم</p>
                    <p class="text-3xl font-bold text-gray-100 mt-2">{{ $todayAppointmentsCount }}</p>
                    <a href="{{ route('appointments.index') }}" class="link text-sm mt-3 inline-flex">عرض المعاملات &larr;</a>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-sky-500/15 text-sky-300 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="section-title">جدول اليوم</h2>
            <span class="text-sm text-gray-400">آخر تحديث {{ now()->format('H:i') }}</span>
        </div>
        <div class="overflow-x-auto rounded-lg border border-gray-800/60">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-right">الوقت</th>
                        <th class="text-right">المريض</th>
                        <th class="text-right">الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($todayAppointments as $apt)
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
                            <td class="text-sm text-gray-100">{{ $apt->date->format('H:i') }}</td>
                            <td class="text-sm text-gray-100">{{ $apt->patient->fullName }}</td>
                            <td>
                                <span class="badge {{ $statusClass }}">{{ $apt->status }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-400">لا توجد مواعيد اليوم.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $todayAppointments->links('vendor.pagination.dark') }}
        </div>
    </div>
@endsection