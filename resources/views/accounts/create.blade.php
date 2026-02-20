@extends('layouts.app')

@section('header', 'إضافة مريض جديد')

@section('content')
    <div class="card p-8 max-w-4xl mx-auto">
        <form action="{{ route('patients.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="label">الاسم الكامل</label>
                    <input type="text" name="fullName" class="input" required>
                </div>
                <div>
                    <label class="label">رقم الهاتف</label>
                    <input type="text" name="phoneNumber" class="input" required>
                </div>
                <div>
                    <label class="label">تاريخ الميلاد</label>
                    <input type="date" name="dob" class="input" required>
                </div>
                <div>
                    <label class="label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="input">
                </div>
                <div class="col-span-2">
                    <label class="label">التاريخ الطبي</label>
                    <textarea name="medicalHistory" rows="3" class="textarea"></textarea>
                </div>
            </div>
            
            <div class="flex justify-start space-x-4 space-x-reverse mt-6">
                <button type="submit" class="btn btn-primary">حفظ</button>
                <a href="{{ route('patients.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection