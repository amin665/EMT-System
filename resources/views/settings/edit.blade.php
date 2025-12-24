@extends('layouts.app')

@section('header', 'الإعدادات')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-4xl mx-auto">
        <div class="border border-yellow-200 p-6 rounded-lg bg-yellow-50 mb-6">
            <h3 class="text-xl font-bold text-yellow-800 mb-3">قالب رسالة تذكير SMS التلقائية</h3>
            <p class="text-sm text-gray-600 mb-4">يتم إرسال هذه الرسالة تلقائياً قبل 24 ساعة.</p>
            
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <textarea name="telegram_message_template" rows="3" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-right" required>{{ $user->telegram_message_template }}</textarea>
                    <small class="text-gray-500">استخدم <code>{time}</code> و <code>{patient}</code> كمتغيرات.</small>
                </div>
                <button type="submit" class="bg-primary text-white py-2 px-6 rounded-lg font-semibold hover:bg-green-600 transition shadow">حفظ الإعدادات</button>
            </form>
        </div>
    </div>
@endsection