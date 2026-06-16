<x-guest-layout>
    <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.875rem;color:#6b7280;text-decoration:none;margin-bottom:16px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
    <h1 class="auth-title">Masuk ke akun</h1>
    <p class="auth-subtitle">Akses kursus, progres belajar, dan semua fitur KursusKu dalam satu tempat.</p>

    <x-auth-session-status class="auth-error" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-field">
            <label for="email" class="auth-label">Email kamu</label>
            <input id="email" type="email" name="email" class="auth-input"
                value="{{ old('email') }}" required autofocus autocomplete="username"
                placeholder="contoh@email.com">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Password</label>
            <div class="auth-input-wrap">
                <input id="password" type="password" name="password" class="auth-input"
                    required autocomplete="current-password" placeholder="••••••••••"
                    style="padding-right: 40px;">
                <button type="button" class="auth-input-icon" onclick="togglePassword('password', this)">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <span class="auth-error">{{ $message }}</span>
            @enderror
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="auth-forgot">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="auth-btn">Masuk</button>
    </form>

    <br>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar</a>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.style.color = isHidden ? '#4f46e5' : '#9ca3af';
        }
    </script>
</x-guest-layout>
