@extends('layouts.app')

@section('header', 'الإعدادات')

@section('content')
    <div class="card p-8 max-w-4xl mx-auto">
        <div class="mb-10">
            <h3 class="text-xl font-bold mb-3">المظهر</h3>
            <p class="text-sm text-gray-400 mb-6">اختر نمط الواجهة ولون العلامة الأساسي. يتم حفظ الإعدادات تلقائياً.</p>

            <div class="flex flex-wrap gap-3 mb-6">
                <button type="button" class="theme-toggle" data-theme-option="dark">
                    <span>داكن</span>
                </button>
                <button type="button" class="theme-toggle" data-theme-option="light">
                    <span>فاتح</span>
                </button>
            </div>

            <div class="flex flex-wrap items-center gap-3 mb-4">
                <button type="button" class="accent-swatch" style="background:#ef4444" data-accent-option="#EF4444" aria-label="أحمر"></button>
                <button type="button" class="accent-swatch" style="background:#22c55e" data-accent-option="#22C55E" aria-label="أخضر"></button>
                <button type="button" class="accent-swatch" style="background:#3b82f6" data-accent-option="#3B82F6" aria-label="أزرق"></button>
                <button type="button" class="accent-swatch" style="background:#f59e0b" data-accent-option="#F59E0B" aria-label="أصفر"></button>
                <button type="button" class="accent-swatch" style="background:#14b8a6" data-accent-option="#14B8A6" aria-label="تركواز"></button>
            </div>

            <div class="flex items-center gap-3">
                <label class="label mb-0">لون مخصص</label>
                <input type="color" class="input w-20 h-10 p-1" data-accent-picker>
            </div>
        </div>

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