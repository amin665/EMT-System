@extends('layouts.app')

@section('header', 'تعديل الموعد')

@section('content')
    <div class="card p-8 max-w-2xl mx-auto">
        
        <!-- Info Alert -->
        <div class="alert alert-info mb-6">
            <p class="text-sm text-sky-200">
                <strong>ملاحظة:</strong> تغيير وقت الموعد سيقوم تلقائياً بتحديث الحالة إلى "مؤجل" (Delayed) إذا لم تقم بتغييرها يدوياً.
            </p>
        </div>

        <form action="{{ route('appointments.update', $appointment->id) }}" method="POST">
            @csrf @method('PUT')
            
            <div class="space-y-6">
                <!-- Patient Name (Read Only) -->
                <div>
                    <label class="label">المريض</label>
                    <input type="text" value="{{ $appointment->patient->fullName }}" class="input" disabled>
                </div>

                <!-- Date & Time -->
                <div>
                    <label class="label">التاريخ والوقت</label>
                    <!-- Pre-fill with the correct format for datetime-local input -->
                    <input type="datetime-local" name="date" value="{{ $appointment->date->format('Y-m-d\TH:i') }}" class="input" required>
                </div>

                <!-- Status -->
                <div>
                    <label class="label">الحالة</label>
                    <select name="status" class="select">
                        <option value="Scheduled" {{ $appointment->status == 'Scheduled' ? 'selected' : '' }}>مجدول (Scheduled)</option>
                        <option value="Done" {{ $appointment->status == 'Done' ? 'selected' : '' }}>تم (Done)</option>
                        <option value="Delayed" {{ $appointment->status == 'Delayed' ? 'selected' : '' }}>مؤجل (Delayed)</option>
                        <option value="Canceled" {{ $appointment->status == 'Canceled' ? 'selected' : '' }}>ملغى (Canceled)</option>
                    </select>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-start space-x-4 space-x-reverse mt-8">
                <button type="submit" class="btn btn-primary">
                    تحديث الموعد
                </button>
                <a href="{{ route('appointments.index') }}" class="btn btn-outline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
@endsection