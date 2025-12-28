@extends('layouts.app')

@section('header', 'حجز موعد جديد')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Patient Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">المريض</label>
                    <select name="patientID" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary bg-white text-right" required>
                        <option value="">-- اختر المريض --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->fullName }} ({{ $patient->phoneNumber }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date & Time -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">التاريخ والوقت</label>
                    <input type="datetime-local" name="date" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-right" required>
                    <p class="text-xs text-gray-500 mt-1">يجب أن يكون الموعد في المستقبل، مع مراعاة فاصل 10 دقائق بين المواعيد.</p>
                </div>

                <!-- Status (Default to Scheduled) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">الحالة</label>
                    <select name="status" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary bg-gray-50 text-right">
                        <option value="Scheduled" selected>مجدول (Scheduled)</option>
                        <option value="Done">تم (Done)</option>
                        <option value="Delayed">مؤجل (Delayed)</option>
                        <option value="Canceled">ملغى (Canceled)</option>
                    </select>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-start space-x-4 space-x-reverse mt-8">
                <button type="submit" class="bg-primary text-white py-3 px-8 rounded-lg font-semibold hover:bg-green-600 transition shadow-lg">
                    حجز الموعد
                </button>
                <a href="{{ route('appointments.index') }}" class="border border-gray-300 text-gray-700 py-3 px-8 rounded-lg font-semibold hover:bg-gray-100 transition">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection