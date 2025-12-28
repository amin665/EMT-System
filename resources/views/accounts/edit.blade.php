@extends('layouts.app')

@section('header', 'تعديل بيانات المريض')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل</label>
                    <input type="text" name="fullName" value="{{ $patient->fullName }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-right" required>
                </div>

                <!-- Email (NEW FIELD) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ $patient->email }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-right">
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                    <input type="text" name="phoneNumber" value="{{ $patient->phoneNumber }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-right" required>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ الميلاد</label>
                    <input type="date" name="dob" value="{{ $patient->dob->format('Y-m-d') }}" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-right" required>
                </div>

                <!-- Medical History -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">التاريخ الطبي</label>
                    <textarea name="medicalHistory" rows="3" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-right">{{ $patient->medicalHistory }}</textarea>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-start space-x-4 space-x-reverse mt-6">
                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg font-semibold hover:bg-green-600 transition shadow-md">
                    تحديث البيانات
                </button>
                <a href="{{ route('patients.index') }}" class="border border-gray-300 text-gray-700 py-2 px-6 rounded-lg font-semibold hover:bg-gray-100 transition">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection