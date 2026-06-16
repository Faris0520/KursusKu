<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Kursusku') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/panel.css') }}">
</head>
<body style="font-family:'Inter',sans-serif;margin:0;background:#fff;">

    <nav class="navbar" aria-label="Main navigation">
        <div class="navbar-inner">
            <div style="display:flex;align-items:center;gap:40px;">
                <a href="{{ route('home') }}" class="navbar-logo">Kursusku<span>.</span></a>
                <div class="navbar-links">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('courses.index') }}" class="{{ request()->routeIs('courses.*') ? 'active' : '' }}">Kursus</a>
                </div>
            </div>
            <div class="navbar-actions" x-data="{ open: false }">
                @guest
                    <a href="{{ route('login') }}" class="btn-register">Login</a>
                @else
                    @php
                        $dashUrl = auth()->user()->isAdmin()
                            ? route('admin.dashboard')
                            : (auth()->user()->isMentor()
                                ? route('mentor.dashboard')
                                : route('siswa.dashboard'));
                    @endphp
                    <a href="{{ $dashUrl }}" class="btn-login">Dashboard</a>
                    <div style="position:relative;">
                        <button @click="open = !open" :aria-expanded="open.toString()" aria-haspopup="true" style="display:flex;align-items:center;gap:8px;cursor:pointer;background:none;border:none;padding:0;font-family:'Inter',sans-serif;">
                            <div style="width:32px;height:32px;border-radius:50%;overflow:hidden;background:#e0e7ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <span style="font-size:0.875rem;font-weight:700;color:#2563eb;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <span style="font-size:0.875rem;font-weight:500;color:#374151;">{{ auth()->user()->name }}</span>
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="panel-user-dropdown" x-show="open" @click.away="open = false" x-cloak>
                            <a href="{{ route('profile.edit') }}">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div style="max-width:1200px;margin:16px auto 0;padding:0 24px;">
            <div class="panel-alert panel-alert-success">{{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div style="max-width:1200px;margin:16px auto 0;padding:0 24px;">
            <div class="panel-alert panel-alert-error">{{ session('error') }}</div>
        </div>
    @endif

    <main>{{ $slot }}</main>

    <footer style="background:#fff;border-top:1px solid #f0f0f0;margin-top:60px;padding:28px 0;text-align:center;font-size:0.8125rem;color:#9ca3af;font-family:'Inter',sans-serif;">
        &copy; {{ date('Y') }} Kursusku. All rights reserved.
    </footer>

    @stack('scripts')
</body>
</html>