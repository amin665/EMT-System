@extends('layouts.app')

@section('header', 'تعديل الموعد')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
        
        <!-- Info Alert -->
        <div class="bg-blue-50 border-r-4 border-blue-500 p-4 mb-6 rounded-l">
            <p class="text-sm text-blue-700">
                <strong>ملاحظة:</strong> تغيير وقت الموعد سيقوم تلقائياً بتحديث الحالة إلى "مؤجل" (Delayed) إذا لم تقم بتغييرها يدوياً.
            </p>
        </div>

        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="space-y-6">
                <!-- Patient Name (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">المريض</label>
                    <input type="text" value="{{ $appointment->patient->fullName }}" class="w-full p-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed text-right" disabled>
                </div>

                <!-- Date & Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">التاريخ والوقت</label>
                    <!-- Pre-fill with the correct format for datetime-local input -->
                    <input type="datetime-local" name="date" value="{{ $appointment->date->format('Y-m-d\TH:i') }}" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 text-right" required>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                    <select name="status" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 bg-white text-right">
                        <option value="Scheduled" {{ $appointment->status == 'Scheduled' ? 'selected' : '' }}>مجدول (Scheduled)</option>
                        <option value="Done" {{ $appointment->status == 'Done' ? 'selected' : '' }}>تم (Done)</option>
                        <option value="Delayed" {{ $appointment->status == 'Delayed' ? 'selected' : '' }}>مؤجل (Delayed)</option>
                        <option value="Canceled" {{ $appointment->status == 'Canceled' ? 'selected' : '' }}>ملغى (Canceled)</option>
                    </select>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-start space-x-4 space-x-reverse mt-8">
                <button type="submit" class="bg-yellow-500 text-white py-3 px-8 rounded-lg font-semibold hover:bg-yellow-600 transition shadow-lg">
                    تحديث الموعد
                </button>
                <a href="{{ route('appointments.index') }}" class="border border-gray-300 text-gray-700 py-3 px-8 rounded-lg font-semibold hover:bg-gray-100 transition">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection