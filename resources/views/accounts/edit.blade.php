@extends('layouts.app')

@section('header', 'تعديل بيانات المريض')

@section('content')
    <div class="card p-8 max-w-4xl mx-auto">
        <form action="{{ route('patients.update', $patient->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label class="label">الاسم الكامل</label>
                    <input type="text" name="fullName" value="{{ $patient->fullName }}" class="input" required>
                </div>

                <!-- Email (NEW FIELD) -->
                <div>
                    <label class="label">البريد الإلكتروني</label>
                    <input type="email" name="email" value="{{ $patient->email }}" class="input">
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="label">رقم الهاتف</label>
                    <input type="text" name="phoneNumber" value="{{ $patient->phoneNumber }}" class="input" required>
                </div>

                <!-- Date of Birth -->
                <div>
                    <label class="label">تاريخ الميلاد</label>
                    <input type="date" name="dob" value="{{ $patient->dob->format('Y-m-d') }}" class="input" required>
                </div>

                <!-- Medical History -->
                <div class="col-span-1 md:col-span-2">
                    <label class="label">التاريخ الطبي</label>
                    <textarea name="medicalHistory" rows="3" class="textarea">{{ $patient->medicalHistory }}</textarea>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-start space-x-4 space-x-reverse mt-6">
                <button type="submit" class="btn btn-primary">
                    تحديث البيانات
                </button>
                <a href="{{ route('patients.index') }}" class="btn btn-outline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection