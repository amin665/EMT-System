@extends('layouts.app')

@section('header', 'الإعدادات')

@section('content')
    <div class="card p-8 max-w-4xl mx-auto">
        <div class="alert alert-info mb-6">
            <h3 class="text-xl font-bold text-sky-100 mb-3">قالب رسالة تذكير SMS التلقائية</h3>
            <p class="text-sm text-sky-200 mb-4">يتم إرسال هذه الرسالة تلقائياً قبل 24 ساعة.</p>
            
            <form action="{{ route('settings.update') }}" method="POST">
                @csrf @method('PUT')
                <div class="mb-4">
                    <textarea name="telegram_message_template" rows="3" class="textarea" required>{{ $user->telegram_message_template }}</textarea>
                    <small class="help-text">استخدم <code>{time}</code> و <code>{patient}</code> كمتغيرات.</small>
                </div>
                <button type="submit" class="btn btn-primary">حفظ الإعدادات</button>
            </form>
        </div>
    </div>
@endsection