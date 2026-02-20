@extends('layouts.app')

@section('header', 'حجز موعد جديد')

@section('content')
    <div class="card p-8 max-w-2xl mx-auto">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            
            <div class="space-y-6">
                <!-- Patient Selection -->
                <div>
                    <label class="label">المريض</label>
                    <select name="patientID" class="select" required>
                        <option value="">-- اختر المريض --</option>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}">{{ $patient->fullName }} ({{ $patient->phoneNumber }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date & Time -->
                <div>
                    <label class="label">التاريخ والوقت</label>
                    <input type="datetime-local" name="date" class="input" required>
                    <p class="help-text mt-1">يجب أن يكون الموعد في المستقبل، مع مراعاة فاصل 10 دقائق بين المواعيد.</p>
                </div>

                <!-- Status (Default to Scheduled) -->
                <div>
                    <label class="label">الحالة</label>
                    <select name="status" class="select">
                        <option value="Scheduled" selected>مجدول (Scheduled)</option>
                        <option value="Done">تم (Done)</option>
                        <option value="Delayed">مؤجل (Delayed)</option>
                        <option value="Canceled">ملغى (Canceled)</option>
                    </select>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-start space-x-4 space-x-reverse mt-8">
                <button type="submit" class="btn btn-primary">
                    حجز الموعد
                </button>
                <a href="{{ route('appointments.index') }}" class="btn btn-outline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection