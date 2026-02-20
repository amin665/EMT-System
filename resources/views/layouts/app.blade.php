<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMT System - نظام السجلات الطبية</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['IBM Plex Sans Arabic', 'Tajawal', 'sans-serif'] },
                    colors: {
                        'primary': '#F43F5E',
                        'secondary': '#0F172A',
                        'accent': '#FB7185',
                        'danger': '#EF4444',
                        'bg-dark': '#0B0F14',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --bg: #0b0f14;
            --bg-2: #0d131b;
            --surface: #111827;
            --surface-2: #0f172a;
            --border: #1f2a37;
            --text: #e5e7eb;
            --muted: #94a3b8;
            --accent: #fb7185;
            --accent-strong: #f43f5e;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
        }
        body {
            font-family: 'IBM Plex Sans Arabic', 'Tajawal', sans-serif;
            background: radial-gradient(1200px 800px at 10% 0%, rgba(251, 113, 133, 0.08), transparent 60%),
                        radial-gradient(900px 600px at 90% 10%, rgba(56, 189, 248, 0.07), transparent 55%),
                        var(--bg);
            color: var(--text);
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(148, 163, 184, 0.08) 1px, transparent 0);
            background-size: 28px 28px;
            opacity: 0.45;
            pointer-events: none;
            z-index: 0;
        }
        input, textarea, select { text-align: right; }
        input::placeholder, textarea::placeholder { color: rgba(148, 163, 184, 0.7); }
        input[type="date"],
        input[type="time"],
        input[type="datetime-local"] {
            color-scheme: dark;
        }
        .app-shell { position: relative; z-index: 1; }
        .sidebar {
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.95), rgba(10, 15, 23, 0.98));
            border-left: 1px solid var(--border);
            backdrop-filter: blur(14px);
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 14px;
            color: var(--muted);
            transition: all 0.2s ease;
        }
        .sidebar-link:hover {
            color: var(--text);
            background: rgba(148, 163, 184, 0.12);
        }
        .sidebar-link.is-active {
            color: #fff;
            background: rgba(244, 63, 94, 0.18);
            box-shadow: inset 0 0 0 1px rgba(244, 63, 94, 0.35);
        }
        .app-main { background: transparent; }
        .page-title { color: #f8fafc; letter-spacing: -0.01em; }
        .date-chip {
            background: rgba(148, 163, 184, 0.12);
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 0.35rem 0.8rem;
            border-radius: 999px;
            font-size: 0.85rem;
        }
        .card {
            background: linear-gradient(180deg, rgba(17, 24, 39, 0.96), rgba(11, 18, 32, 0.98));
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
        }
        .card-muted {
            background: rgba(15, 23, 42, 0.8);
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #f8fafc;
        }
        .label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 0.35rem;
        }
        .input,
        .select,
        .textarea {
            width: 100%;
            background: #0b1220;
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 12px;
            padding: 0.65rem 0.85rem;
            transition: all 0.2s ease;
        }
        .input:focus,
        .select:focus,
        .textarea:focus {
            outline: none;
            border-color: rgba(244, 63, 94, 0.7);
            box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.2);
        }
        .input:disabled,
        .select:disabled,
        .textarea:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            background: rgba(15, 23, 42, 0.55);
        }
        .textarea { resize: vertical; }
        .help-text { font-size: 0.75rem; color: var(--muted); }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 1.1rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary {
            background: var(--accent-strong);
            color: #fff;
            box-shadow: 0 12px 24px rgba(244, 63, 94, 0.25);
        }
        .btn-primary:hover { background: var(--accent); }
        .btn-outline {
            border: 1px solid var(--border);
            color: var(--text);
            background: rgba(255, 255, 255, 0.02);
        }
        .btn-outline:hover {
            border-color: rgba(244, 63, 94, 0.6);
            color: #fff;
        }
        .btn-danger {
            background: var(--danger);
            color: #fff;
        }
        .btn-ghost { color: var(--muted); }
        .link { color: var(--accent); transition: color 0.2s ease; }
        .link:hover { color: #fda4af; }
        .link-danger { color: var(--danger); }
        .link-muted { color: var(--muted); }
        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .table thead th {
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 0.7rem;
            color: var(--muted);
            background: #0f1624;
            border-bottom: 1px solid var(--border);
            padding: 0.85rem 1rem;
        }
        .table tbody td {
            padding: 0.85rem 1rem;
            border-bottom: 1px solid var(--border);
            color: var(--text);
        }
        .table tbody tr:hover { background: rgba(148, 163, 184, 0.08); }
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.2rem 0.65rem;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 600;
            border: 1px solid transparent;
        }
        .badge-info { background: rgba(56, 189, 248, 0.15); color: #7dd3fc; border-color: rgba(56, 189, 248, 0.35); }
        .badge-success { background: rgba(34, 197, 94, 0.16); color: #86efac; border-color: rgba(34, 197, 94, 0.4); }
        .badge-warning { background: rgba(245, 158, 11, 0.16); color: #fcd34d; border-color: rgba(245, 158, 11, 0.4); }
        .badge-danger { background: rgba(239, 68, 68, 0.18); color: #fca5a5; border-color: rgba(239, 68, 68, 0.4); }
        .badge-neutral { background: rgba(148, 163, 184, 0.12); color: var(--muted); border-color: rgba(148, 163, 184, 0.35); }
        .alert {
            border-radius: 14px;
            border: 1px solid var(--border);
            padding: 1rem 1.1rem;
            color: var(--text);
            background: rgba(15, 23, 42, 0.7);
        }
        .alert-info { border-color: rgba(56, 189, 248, 0.35); background: rgba(14, 116, 144, 0.16); }
        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            align-items: center;
            justify-content: space-between;
        }
        .pagination-links { display: flex; flex-wrap: wrap; gap: 0.4rem; }
        .pagination-link {
            padding: 0.45rem 0.7rem;
            border-radius: 10px;
            border: 1px solid var(--border);
            color: var(--muted);
            background: rgba(15, 23, 42, 0.6);
            transition: all 0.2s ease;
        }
        .pagination-link:hover { color: #fff; border-color: rgba(244, 63, 94, 0.5); }
        .pagination-link.is-active {
            background: rgba(244, 63, 94, 0.18);
            color: #fff;
            border-color: rgba(244, 63, 94, 0.6);
        }
        .pagination-link.is-disabled { opacity: 0.45; cursor: not-allowed; }
        .animate-fade {
            animation: fadeUp 0.6s ease forwards;
            opacity: 0;
            transform: translateY(12px);
        }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
        .swal2-popup {
            background: #0f172a;
            color: var(--text);
            border: 1px solid var(--border);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
        }
        .swal2-title, .swal2-html-container { color: var(--text); }
        .swal2-confirm {
            background: var(--accent-strong);
            color: #fff;
            border-radius: 12px;
            padding: 0.6rem 1rem;
            font-weight: 600;
            border: none;
        }
        .swal2-cancel {
            background: rgba(148, 163, 184, 0.12);
            color: var(--text);
            border-radius: 12px;
            padding: 0.6rem 1rem;
            font-weight: 600;
            border: 1px solid var(--border);
        }
    </style>
</head>
<body class="app-shell h-screen overflow-hidden flex">

    <!-- Sidebar -->
    <aside class="sidebar w-64 text-white flex flex-col p-4 shadow-xl h-full fixed right-0 top-0 overflow-y-auto z-10">
        <div class="text-2xl font-bold mb-8 text-primary text-center">EMT System</div>
        
        <nav class="space-y-2 flex-1">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6m-6 0h-2a1 1 0 01-1-1v-4m7 5c0-4.418 3.582-8 8-8s8 3.582 8 8"></path></svg>
                لوحة التحكم
            </a>
            
            <a href="{{ route('patients.index') }}" class="sidebar-link {{ request()->routeIs('patients.*') ? 'is-active' : '' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                المرضى
            </a>
            
            <a href="{{ route('appointments.index') }}" class="sidebar-link {{ request()->routeIs('appointments.*') ? 'is-active' : '' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                المواعيد
            </a>
            
            <a href="{{ route('settings.edit') }}" class="sidebar-link {{ request()->routeIs('settings.*') ? 'is-active' : '' }}">
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.526.315 1.066.315 1.59 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                الإعدادات
            </a>
        </nav>

        <div class="pt-4 border-t border-gray-700 text-center">
            <div class="text-sm mb-2 text-gray-300">د. {{ auth()->user()->name }}</div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs link">تسجيل الخروج</button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="app-main flex-1 mr-64 h-full overflow-y-auto p-8">
        <header class="mb-8 flex justify-between items-center">
            <h1 class="page-title text-3xl font-bold">
                @yield('header', 'لوحة التحكم')
            </h1>
            <div class="date-chip">{{ now()->format('Y-m-d') }}</div>
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
                confirmButtonText: 'حسناً',
                customClass: {
                    popup: 'swal2-popup',
                    confirmButton: 'swal2-confirm'
                },
                buttonsStyling: false
            });
        @endif

        // Error Message
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                html: '<ul class="text-right list-disc pr-4">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'حسناً',
                customClass: {
                    popup: 'swal2-popup',
                    confirmButton: 'swal2-confirm'
                },
                buttonsStyling: false
            });
        @endif

        // Delete Confirmation
        function confirmDelete(formId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لا يمكن التراجع عن هذا الإجراء!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء',
                customClass: {
                    popup: 'swal2-popup',
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                },
                buttonsStyling: false
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