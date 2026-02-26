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
                <div class="relative">
                    <textarea id="medicalHistory" name="medicalHistory" rows="3" 
                        class="textarea w-full pr-3 pl-12" 
                        placeholder="...اكتب هنا أو استخدم الميكروفون"></textarea>
                    
                    <button type="button" id="micBtn" 
                        class="absolute bottom-3 left-3 p-2 rounded-full transition-all duration-300 text-pink-500 hover:bg-white/10 flex items-center justify-center">
                        <svg id="micIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                        <span id="recordingStatus" class="hidden text-xs mr-2 font-bold">LIVE</span>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="flex justify-start space-x-4 space-x-reverse mt-6">
            <button type="submit" class="btn btn-primary">حفظ المريض</button>
            <a href="{{ route('patients.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </form>
</div>

