<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KursusKu') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100" x-data="{ mobileOpen: false }">
    <!-- Navbar -->
    <nav class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">KursusKu</a>

                    <!-- Nav Links Desktop -->
                    <div class="hidden md:flex ml-8 space-x-4">
                        <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Kursus</a>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Admin</a>
                            @elseif(auth()->user()->isMentor())
                                <a href="{{ route('mentor.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Mentor Panel</a>
                            @else
                                <a href="{{ route('siswa.dashboard') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Kursus Saya</a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Right Side -->
                <div class="flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-indigo-700">Register</a>
                    @else
                        <div class="relative" x-data="{ open: false }">
                            <button@click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-indigo-600">
                                {{ auth()->user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open"@click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @endguest

                    <!-- Mobile Hamburger -->
                    <div class="md:hidden">
                        <button@click="mobileOpen = !mobileOpen" class="text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" class="md:hidden border-t">
            <div class="px-4 py-3 space-y-2">
                <a href="{{ route('courses.index') }}" class="block text-gray-700 py-2">Kursus</a>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block text-gray-700 py-2">Admin</a>
                    @elseif(auth()->user()->isMentor())
                        <a href="{{ route('mentor.dashboard') }}" class="block text-gray-700 py-2">Mentor Panel</a>
                    @else
                        <a href="{{ route('siswa.dashboard') }}" class="block text-gray-700 py-2">Kursus Saya</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <!-- Header -->
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <x-alert type="success" :message="session('success')"/>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <x-alert type="error" :message="session('error')"/>
        </div>
    @endif

    <!-- Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} KursusKu. Project UAS PBP.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>