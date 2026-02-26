<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            --accent-rgb: 244, 63, 94;
            --success: #22c55e;
            --warning: #f59e0b;
            --danger: #ef4444;
            --shadow: 0 20px 45px rgba(0, 0, 0, 0.35);
        }
        [data-theme="light"] {
            --bg: #f8fafc;
            --bg-2: #eef2f7;
            --surface: #ffffff;
            --surface-2: #f1f5f9;
            --border: #e2e8f0;
            --text: #0f172a;
            --muted: #64748b;
            --shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
        }
        html[data-theme="dark"] { color-scheme: dark; }
        html[data-theme="light"] { color-scheme: light; }
        body {
            font-family: 'IBM Plex Sans Arabic', 'Tajawal', sans-serif;
            background: radial-gradient(1200px 800px at 10% 0%, rgba(var(--accent-rgb), 0.12), transparent 60%),
                        radial-gradient(900px 600px at 90% 10%, rgba(56, 189, 248, 0.08), transparent 55%),
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
        html[data-theme="dark"] input[type="date"],
        html[data-theme="dark"] input[type="time"],
        html[data-theme="dark"] input[type="datetime-local"] {
            color-scheme: dark;
        }
        html[data-theme="light"] input[type="date"],
        html[data-theme="light"] input[type="time"],
        html[data-theme="light"] input[type="datetime-local"] {
            color-scheme: light;
        }
        .app-shell { position: relative; z-index: 1; }
        .sidebar {
            background: linear-gradient(180deg, var(--surface), var(--surface-2));
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
            background: rgba(var(--accent-rgb), 0.18);
            box-shadow: inset 0 0 0 1px rgba(var(--accent-rgb), 0.35);
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
            background: linear-gradient(180deg, var(--surface), var(--surface-2));
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }
        .card-muted {
            background: var(--surface-2);
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
            background: var(--surface-2);
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
            border-color: rgba(var(--accent-rgb), 0.7);
            box-shadow: 0 0 0 3px rgba(var(--accent-rgb), 0.2);
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
            box-shadow: 0 12px 24px rgba(var(--accent-rgb), 0.25);
        }
        .btn-primary:hover { background: var(--accent); }
        .btn-outline {
            border: 1px solid var(--border);
            color: var(--text);
            background: rgba(148, 163, 184, 0.08);
        }
        .btn-outline:hover {
            border-color: rgba(var(--accent-rgb), 0.6);
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
            background: var(--surface-2);
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
            background: var(--surface-2);
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
            background: var(--surface-2);
            transition: all 0.2s ease;
        }
        .pagination-link:hover { color: #fff; border-color: rgba(var(--accent-rgb), 0.5); }
        .pagination-link.is-active {
            background: rgba(var(--accent-rgb), 0.18);
            color: #fff;
            border-color: rgba(var(--accent-rgb), 0.6);
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
            background: var(--surface);
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
        .theme-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.45rem 0.9rem;
            border-radius: 999px;
            border: 1px solid var(--border);
            color: var(--muted);
            background: rgba(15, 23, 42, 0.3);
            transition: all 0.2s ease;
        }
        .theme-toggle.is-active {
            color: var(--text);
            border-color: rgba(var(--accent-rgb), 0.6);
            background: rgba(var(--accent-rgb), 0.12);
        }
        .accent-swatch {
            width: 2rem;
            height: 2rem;
            border-radius: 999px;
            border: 2px solid transparent;
            box-shadow: inset 0 0 0 1px rgba(15, 23, 42, 0.2);
            transition: all 0.2s ease;
        }
        .accent-swatch.is-active {
            border-color: rgba(var(--accent-rgb), 0.8);
            box-shadow: 0 0 0 3px rgba(var(--accent-rgb), 0.2);
        }
        .text-gray-100,
        .text-gray-800 { color: var(--text) !important; }
        .text-gray-300,
        .text-gray-400,
        .text-gray-700 { color: var(--muted) !important; }
        .text-sky-100 { color: var(--text) !important; }
        .text-sky-200 { color: var(--muted) !important; }
        .bg-gray-100 { background-color: var(--bg-2) !important; }
        .bg-white { background-color: var(--surface) !important; }
        .border-gray-300,
        .border-gray-700,
        .border-gray-800\/60 { border-color: var(--border) !important; }
        .text-primary { color: var(--accent-strong) !important; }
        .bg-primary { background-color: var(--accent-strong) !important; }
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
        (function () {
            const storedTheme = localStorage.getItem('emt-theme') || 'dark';
            const storedAccent = localStorage.getItem('emt-accent') || '#F43F5E';

            function clampChannel(value) {
                return Math.max(0, Math.min(255, value));
            }

            function hexToRgb(hex) {
                const cleaned = hex.replace('#', '');
                if (cleaned.length !== 6) return { r: 244, g: 63, b: 94 };
                const r = parseInt(cleaned.slice(0, 2), 16);
                const g = parseInt(cleaned.slice(2, 4), 16);
                const b = parseInt(cleaned.slice(4, 6), 16);
                return { r, g, b };
            }

            function adjustColor(hex, amount) {
                const { r, g, b } = hexToRgb(hex);
                const nr = clampChannel(r + amount);
                const ng = clampChannel(g + amount);
                const nb = clampChannel(b + amount);
                return `#${nr.toString(16).padStart(2, '0')}${ng.toString(16).padStart(2, '0')}${nb.toString(16).padStart(2, '0')}`;
            }

            function applyTheme(theme) {
                document.documentElement.dataset.theme = theme;
            }

            function applyAccent(color) {
                const strong = adjustColor(color, -10);
                const soft = adjustColor(color, 24);
                const { r, g, b } = hexToRgb(strong);
                document.documentElement.style.setProperty('--accent-strong', strong);
                document.documentElement.style.setProperty('--accent', soft);
                document.documentElement.style.setProperty('--accent-rgb', `${r}, ${g}, ${b}`);
            }

            applyTheme(storedTheme);
            applyAccent(storedAccent);

            window.__applyEmtTheme = applyTheme;
            window.__applyEmtAccent = applyAccent;
        })();

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

        document.addEventListener('DOMContentLoaded', function () {
            const themeButtons = document.querySelectorAll('[data-theme-option]');
            const accentButtons = document.querySelectorAll('[data-accent-option]');
            const accentPicker = document.querySelector('[data-accent-picker]');
            const storedTheme = localStorage.getItem('emt-theme') || 'dark';
            const storedAccent = localStorage.getItem('emt-accent') || '#F43F5E';

            themeButtons.forEach((button) => {
                const value = button.getAttribute('data-theme-option');
                button.classList.toggle('is-active', value === storedTheme);
                button.addEventListener('click', () => {
                    localStorage.setItem('emt-theme', value);
                    window.__applyEmtTheme(value);
                    themeButtons.forEach((item) => item.classList.remove('is-active'));
                    button.classList.add('is-active');
                });
            });

            accentButtons.forEach((button) => {
                const value = button.getAttribute('data-accent-option');
                button.classList.toggle('is-active', value.toLowerCase() === storedAccent.toLowerCase());
                button.addEventListener('click', () => {
                    localStorage.setItem('emt-accent', value);
                    window.__applyEmtAccent(value);
                    accentButtons.forEach((item) => item.classList.remove('is-active'));
                    button.classList.add('is-active');
                    if (accentPicker) {
                        accentPicker.value = value;
                    }
                });
            });

            if (accentPicker) {
                accentPicker.value = storedAccent;
                accentPicker.addEventListener('input', (event) => {
                    const value = event.target.value;
                    localStorage.setItem('emt-accent', value);
                    window.__applyEmtAccent(value);
                    accentButtons.forEach((item) => item.classList.remove('is-active'));
                });
            }
        });
    </script>
</body>
</html>