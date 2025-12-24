@extends('layouts.app')

@section('header', 'إدارة المواعيد')

@section('content')
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">جدول المواعيد</h2>
            <a href="{{ route('appointments.create') }}" class="bg-accent text-white py-2 px-4 rounded-lg font-medium hover:bg-blue-600 transition shadow-md">
                + موعد جديد
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الوقت</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">المريض</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الحالة</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($appointments as $apt)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $apt->date->format('Y-m-d H:i') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $apt->patient->fullName }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $apt->status == 'Scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $apt->status == 'Done' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $apt->status == 'Canceled' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $apt->status == 'Delayed' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ $apt->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-left space-x-2 space-x-reverse">
                                <a href="{{ route('appointments.edit', $apt->id) }}" class="text-yellow-600 hover:underline">تعديل</a>
                                @if($apt->status != 'Canceled')
                                    <form id="cancel-apt-{{ $apt->id }}" action="{{ route('appointments.destroy', $apt->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" class="text-danger hover:underline" onclick="confirmDelete('cancel-apt-{{ $apt->id }}')">إلغاء</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection