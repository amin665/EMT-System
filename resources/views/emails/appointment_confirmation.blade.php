<!DOCTYPE html>
<html>
<head>
    <title>Appointment Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; text-align: right; direction: rtl;">
    <h2>مرحباً {{ $appointment->patient->fullName }}</h2>
    <p>تم حجز موعدك بنجاح.</p>
    
    <p><strong>التفاصيل:</strong></p>
    <ul>
        <li><strong>التاريخ والوقت:</strong> {{ $appointment->date->format('Y-m-d h:i A') }}</li>
        <li><strong>الدكتور:</strong> {{ $appointment->doctor->name }}</li>
        <li><strong>الحالة:</strong> {{ $appointment->status }}</li>
    </ul>

    <p>شكراً لاستخدامك نظام EMT.</p>
</body>
</html>