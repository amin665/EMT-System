@extends('layouts.app')

@section('header', 'لوحة التحكم')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Stats Card 1 -->
        <div class="bg-white p-6 rounded-xl shadow-lg border-r-4 border-primary">
            <p class="text-sm font-medium text-gray-500">إجمالي المرضى</p>
            <p class="text-3xl font-bold text-gray-900">{{ $totalPatients }}</p>
            <a href="{{ route('patients.index') }}" class="text-accent text-sm mt-2 block hover:underline">عرض الحسابات &larr;</a>
        </div>
        
        <!-- Stats Card 2 -->
        <div class="bg-white p-6 rounded-xl shadow-lg border-r-4 border-accent">
            <p class="text-sm font-medium text-gray-500">مواعيد اليوم</p>
            <p class="text-3xl font-bold text-gray-900">{{ $todayAppointments->count() }}</p>
            <a href="{{ route('appointments.index') }}" class="text-accent text-sm mt-2 block hover:underline">عرض المعاملات &larr;</a>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">جدول اليوم</h2>
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الوقت</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">المريض</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الحالة</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($todayAppointments as $apt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $apt->date->format('H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $apt->patient->fullName }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $apt->status == 'Scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $apt->status == 'Done' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $apt->status == 'Canceled' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $apt->status == 'Delayed' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ $apt->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">لا توجد مواعيد اليوم.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection