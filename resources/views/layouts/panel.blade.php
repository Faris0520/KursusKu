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
<body class="panel-body" x-data="{ mobileOpen: false }">

<!-- Topbar -->
<header class="panel-topbar">
    <a href="{{ route('home') }}" class="panel-topbar-logo">Kursusku<span>.</span></a>
    <button class="panel-hamburger" @click="mobileOpen = !mobileOpen">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
    <div style="position:relative;" x-data="{ open: false }">
        <button class="panel-user-btn" @click="open = !open">
            {{ auth()->user()->name }}
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>
        <div class="panel-user-dropdown" x-show="open" @click.away="open = false" x-cloak>
            <a href="{{ route('profile.edit') }}">Profil Saya</a>
            <a href="{{ route('home') }}">Beranda</a>
            <form method="POST" action="{{ route('logout') }}" style="margin:0">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>

<!-- Body -->
<div class="panel-wrapper">
    <div class="panel-sidebar-backdrop"
         x-show="mobileOpen"
         @click="mobileOpen = false"
         x-cloak>
    </div>
    <!-- Sidebar -->
    <aside class="panel-sidebar" :class="{ 'mobile-open': mobileOpen }">
        @auth
            @if(auth()->user()->isMentor())
                <p class="sidebar-section-label">Menu</p>
                <a href="{{ route('mentor.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <p class="sidebar-section-label">Kursus</p>
                <a href="{{ route('mentor.courses.index') }}" class="sidebar-nav-link {{ request()->routeIs('mentor.courses.index') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Kursus Saya
                </a>
                @can('create-course')
                <a href="{{ route('mentor.courses.create') }}" class="sidebar-nav-link {{ request()->routeIs('mentor.courses.create') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Kursus
                </a>
                @endcan
                <p class="sidebar-section-label">Akun</p>
                <a href="{{ route('profile.edit') }}" class="sidebar-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil
                </a>

            @elseif(auth()->user()->isAdmin())
                <p class="sidebar-section-label">Admin</p>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Admin Panel
                </a>
                <p class="sidebar-section-label">Akun</p>
                <a href="{{ route('profile.edit') }}" class="sidebar-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil
                </a>

            @else
                <p class="sidebar-section-label">Menu</p>
                <a href="{{ route('siswa.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('courses.index') }}" class="sidebar-nav-link {{ request()->routeIs('courses.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari Kursus
                </a>
                <a href="{{ route('transactions.history') }}" class="sidebar-nav-link {{ request()->routeIs('transactions.history') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Transaksi
                </a>
                <p class="sidebar-section-label">Akun</p>
                <a href="{{ route('profile.edit') }}" class="sidebar-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profil
                </a>
            @endif
        @endauth
    </aside>

    <!-- Main -->
    <main class="panel-main">
        <div class="panel-content">
            @if(session('success'))
                <div class="panel-alert panel-alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="panel-alert panel-alert-error">{{ session('error') }}</div>
            @endif
            {{ $slot }}
        </div>
    </main>
</div>

@stack('scripts')
</body>
</html>