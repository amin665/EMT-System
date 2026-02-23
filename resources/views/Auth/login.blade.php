<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - EMT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&family=Tajawal:wght@400;700&display=swap" rel="stylesheet">
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
        .auth-shell { position: relative; z-index: 1; }
        .card {
            background: linear-gradient(180deg, var(--surface), var(--surface-2));
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: var(--shadow);
        }
        .label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--muted);
            margin-bottom: 0.35rem;
            text-align: right;
        }
        .input {
            width: 100%;
            background: var(--surface-2);
            border: 1px solid var(--border);
            color: var(--text);
            border-radius: 12px;
            padding: 0.75rem 0.9rem;
            transition: all 0.2s ease;
            text-align: right;
        }
        .input:focus {
            outline: none;
            border-color: rgba(var(--accent-rgb), 0.7);
            box-shadow: 0 0 0 3px rgba(var(--accent-rgb), 0.2);
        }
        .btn-primary {
            background: var(--accent-strong);
            color: #fff;
            border-radius: 12px;
            padding: 0.75rem 1.1rem;
            font-weight: 600;
            transition: all 0.2s ease;
            box-shadow: 0 12px 24px rgba(var(--accent-rgb), 0.25);
        }
        .btn-primary:hover { background: var(--accent); }
        .text-gray-400 { color: var(--muted) !important; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

<div class="auth-shell w-full px-6">
    <div class="card p-8 md:p-10 w-full max-w-sm mx-auto">
        <div class="text-center mb-8">
            <div class="text-sm text-gray-400 mb-2">EMT System</div>
            <h1 class="text-3xl font-bold mb-1">تسجيل الدخول</h1>
            <p class="text-sm text-gray-400">واجهة موحدة مع لوحة التحكم</p>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-5">
                <label class="label">اسم المستخدم</label>
                <input type="text" name="username" class="input" required>
            </div>
            <div class="mb-6">
                <label class="label">كلمة المرور</label>
                <input type="password" name="password" class="input" required>
            </div>

            @if($errors->any())
                <div class="text-red-500 text-sm mb-4 text-center">{{ $errors->first() }}</div>
            @endif

            <button type="submit" class="w-full btn-primary">
                تسجيل الدخول
            </button>
        </form>
    </div>
</div>

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
    })();
</script>

</body>
</html>