<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMT System - نظام السجلات الطبية</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Tajawal', 'sans-serif'] },
                    colors: {
                        'primary': '#10B981',
                        'secondary': '#1F2937',
                        'accent': '#3B82F6',
                        'danger': '#EF4444',
                        'bg-light': '#F9FAFB',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Tajawal', sans-serif; background-color: #F9FAFB; }
        /* Fix text alignment for inputs */
        input, textarea, select { text-align: right; }
    </style>
</head>
<body class="bg-bg-light h-screen overflow-hidden flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-secondary text-white flex flex-col p-4 shadow-xl h-full fixed right-0 top-0 overflow-y-auto z-10">
        <div class="text-2xl font-bold mb-8 text-primary text-center">EMT System</div>
        
        <nav class="space-y-2 flex-1">
            <a href="{{ route('dashboard') }}" class="flex items-center p-3 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6m-6 0h-2a1 1 0 01-1-1v-4m7 5c0-4.418 3.582-8 8-8s8 3.582 8 8"></path></svg>
                لوحة التحكم
            </a>
            
            <a href="{{ route('patients.index') }}" class="flex items-center p-3 rounded-lg transition {{ request()->routeIs('patients.*') ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                المرضى
            </a>
            
            <a href="{{ route('appointments.index') }}" class="flex items-center p-3 rounded-lg transition {{ request()->routeIs('appointments.*') ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                المواعيد
            </a>
            
            <a href="{{ route('settings.edit') }}" class="flex items-center p-3 rounded-lg transition {{ request()->routeIs('settings.*') ? 'bg-gray-700 font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.526.315 1.066.315 1.59 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                الإعدادات
            </a>
        </nav>

        <div class="pt-4 border-t border-gray-700 text-center">
            <div class="text-sm mb-2">د. {{ auth()->user()->name }}</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs text-primary hover:text-white transition">تسجيل الخروج</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 mr-64 h-full overflow-y-auto p-8 bg-gray-100">
        <header class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">
                @yield('header', 'لوحة التحكم')
            </h1>
            <div class="text-gray-500">{{ now()->format('Y-m-d') }}</div>
        </header>

        <!-- Dynamic Content -->
        @yield('content')
    </main>

    <!-- SweetAlert Logic -->
    <script>
        // Success Message
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'نجاح!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#10B981',
                confirmButtonText: 'حسناً'
            });
        @endif

        // Error Message
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                html: '<ul class="text-right list-disc pr-4">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#EF4444',
                confirmButtonText: 'حسناً'
            });
        @endif

        // Delete Confirmation
        function confirmDelete(formId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لا يمكن التراجع عن هذا الإجراء!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#3B82F6',
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
            return false;
        }
    </script>
</body>
</html>