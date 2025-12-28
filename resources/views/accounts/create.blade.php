@extends('layouts.app')

@section('header', 'إضافة مريض جديد')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">الاسم الكامل</label>
                    <input type="text" name="fullName" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                    <input type="text" name="phoneNumber" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">تاريخ الميلاد</label>
                    <input type="date" name="dob" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                    <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">التاريخ الطبي</label>
                    <textarea name="medicalHistory" rows="3" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"></textarea>
                </div>
            </div>
            
            <div class="flex justify-start space-x-4 space-x-reverse mt-6">
                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg font-semibold hover:bg-green-600 transition shadow-md">حفظ</button>
                <a href="{{ route('patients.index') }}" class="border border-gray-300 text-gray-700 py-2 px-6 rounded-lg font-semibold hover:bg-gray-100 transition">إلغاء</a>
            </div>
        </form>
    </div>
@endsection