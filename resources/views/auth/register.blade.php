<x-guest-layout>
    <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:0.875rem;color:#6b7280;text-decoration:none;margin-bottom:16px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>
    <h1 class="auth-title">Buat akun baru</h1>
    <p class="auth-subtitle">Mulai perjalanan belajarmu. Akses kursus dan mentor terbaik, kapan saja.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="auth-field">
            <label for="name" class="auth-label">Nama lengkap</label>
            <input id="name" type="text" name="name" class="auth-input"
                value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="John Doe">
            @error('name')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-field">
            <label for="email" class="auth-label">Email kamu</label>
            <input id="email" type="email" name="email" class="auth-input"
                value="{{ old('email') }}" required autocomplete="username"
                placeholder="contoh@email.com">
            @error('email')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-field">
            <label for="password" class="auth-label">Password</label>
            <div class="auth-input-wrap">
                <input id="password" type="password" name="password" class="auth-input"
                    required autocomplete="new-password" placeholder="••••••••••"
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
        </div>

        <div class="auth-field">
            <label for="password_confirmation" class="auth-label">Konfirmasi password</label>
            <div class="auth-input-wrap">
                <input id="password_confirmation" type="password" name="password_confirmation" class="auth-input"
                    required autocomplete="new-password" placeholder="••••••••••"
                    style="padding-right: 40px;">
                <button type="button" class="auth-input-icon" onclick="togglePassword('password_confirmation', this)">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-field">
            <label for="role" class="auth-label">Daftar sebagai</label>
            <select id="role" name="role" class="auth-input" onchange="toggleMentorReason(this)">
                <option value="siswa" {{ old('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                <option value="mentor" {{ old('role') === 'mentor' ? 'selected' : '' }}>Mentor</option>
            </select>
            @error('role')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="auth-field" id="mentor-reason-field" style="{{ old('role') === 'mentor' ? '' : 'display:none;' }}">
            <label for="mentor_reason" class="auth-label">Alasan ingin menjadi mentor</label>
            <textarea id="mentor_reason" name="mentor_reason" class="auth-input"
                rows="3" placeholder="Ceritakan pengalamanmu dan mengapa kamu ingin mengajar..."
                style="resize:vertical;">{{ old('mentor_reason') }}</textarea>
            @error('mentor_reason')
                <span class="auth-error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="auth-btn">Mulai Sekarang</button>
    </form>

    <div class="auth-footer" style="margin-top: 16px;">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
    </div>

    <script>
        function togglePassword(id, btn) {
            const input = document.getElementById(id);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            btn.style.color = isHidden ? '#4f46e5' : '#9ca3af';
        }

        function toggleMentorReason(select) {
            const field = document.getElementById('mentor-reason-field');
            const textarea = document.getElementById('mentor_reason');
            if (select.value === 'mentor') {
                field.style.display = '';
                textarea.required = true;
            } else {
                field.style.display = 'none';
                textarea.required = false;
            }
        }
    </script>
</x-guest-layout>
