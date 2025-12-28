<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - EMT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Tajawal', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-8 md:p-10 rounded-xl shadow-2xl w-full max-w-sm">
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-1">نظام EMT</h1>
        <p class="text-green-500 font-medium">تسجيل دخول الطبيب</p>
    </div>

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-1 text-right">اسم المستخدم</label>
            <input type="text" name="username" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-right" required>
        </div>
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1 text-right">كلمة المرور</label>
            <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-right" required>
        </div>
        
        @if($errors->any())
            <div class="text-red-500 text-sm mb-4 text-center">{{ $errors->first() }}</div>
        @endif

        <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-semibold hover:bg-green-600 transition shadow-lg">
            تسجيل الدخول
        </button>
    </form>
</div>

</body>
</html>