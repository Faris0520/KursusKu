<x-panel-layout>
<h1 class="panel-page-title" style="margin-bottom:24px;">Profil Saya</h1>

<div style="max-width:640px;">

    {{-- Avatar + Info --}}
    <div class="panel-card" style="display:flex;align-items:center;gap:24px;margin-bottom:24px;padding:24px;">
        <div style="width:88px;height:88px;border-radius:50%;overflow:hidden;background:#e0e7ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                     style="width:100%;height:100%;object-fit:cover;" id="avatar-preview">
            @else
                <img src="" style="width:100%;height:100%;object-fit:cover;display:none;" id="avatar-preview">
                <span id="avatar-initials" style="font-size:2rem;font-weight:700;color:#2563eb;">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            @endif
        </div>
        <div>
            <div style="font-size:1.125rem;font-weight:700;color:#111827;">{{ auth()->user()->name }}</div>
            <div style="font-size:0.875rem;color:#6b7280;margin-top:2px;">{{ auth()->user()->email }}</div>
            <div style="font-size:0.8125rem;font-weight:600;color:#2563eb;margin-top:4px;text-transform:capitalize;">{{ auth()->user()->role }}</div>
        </div>
    </div>

    {{-- Form Info --}}
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="panel-card" style="padding:24px;display:flex;flex-direction:column;gap:20px;margin-bottom:24px;">
            <h2 style="font-size:1rem;font-weight:700;color:#111827;margin:0;">Informasi Profil</h2>

            {{-- Foto Profil --}}
            <div>
                <label style="display:block;font-size:0.875rem;font-weight:600;color:#374151;margin-bottom:8px;">Foto Profil</label>
                <div style="display:flex;align-items:center;gap:12px;">
                    <label for="avatar-input" style="cursor:pointer;background:#f3f4f6;border:1px solid #e5e7eb;border-radius:8px;padding:8px 16px;font-size:0.8125rem;font-weight:500;color:#374151;">
                        Pilih Foto
                    </label>
                    <span id="avatar-filename" style="font-size:0.8125rem;color:#9ca3af;">JPG, PNG, WEBP · maks. 2MB</span>
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none;">
                </div>
                @error('avatar')
                    <p style="font-size:0.8125rem;color:#dc2626;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama --}}
            <div>
                <label for="name" style="display:block;font-size:0.875rem;font-weight:600;color:#374151;margin-bottom:6px;">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}"
                       style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#111827;outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e5e7eb'">
                @error('name')
                    <p style="font-size:0.8125rem;color:#dc2626;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label for="email" style="display:block;font-size:0.875rem;font-weight:600;color:#374151;margin-bottom:6px;">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                       style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;font-size:0.875rem;font-family:'Inter',sans-serif;color:#111827;outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e5e7eb'">
                @error('email')
                    <p style="font-size:0.8125rem;color:#dc2626;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>


            <div>
                <button type="submit"
                        style="background:#2563eb;color:#fff;border:none;border-radius:8px;padding:10px 24px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    {{-- Ganti Password --}}
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="panel-card" style="padding:24px;display:flex;flex-direction:column;gap:16px;">
            <h2 style="font-size:1rem;font-weight:700;color:#111827;margin:0;">Ganti Password</h2>

            <div>
                <label for="current_password" style="display:block;font-size:0.875rem;font-weight:600;color:#374151;margin-bottom:6px;">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password"
                       style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;font-size:0.875rem;font-family:'Inter',sans-serif;outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e5e7eb'">
                @error('current_password', 'updatePassword')
                    <p style="font-size:0.8125rem;color:#dc2626;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" style="display:block;font-size:0.875rem;font-weight:600;color:#374151;margin-bottom:6px;">Password Baru</label>
                <input type="password" id="password" name="password"
                       style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;font-size:0.875rem;font-family:'Inter',sans-serif;outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e5e7eb'">
                @error('password', 'updatePassword')
                    <p style="font-size:0.8125rem;color:#dc2626;margin-top:6px;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" style="display:block;font-size:0.875rem;font-weight:600;color:#374151;margin-bottom:6px;">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                       style="width:100%;border:1px solid #e5e7eb;border-radius:8px;padding:10px 14px;font-size:0.875rem;font-family:'Inter',sans-serif;outline:none;box-sizing:border-box;"
                       onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e5e7eb'">
            </div>

            <div>
                <button type="submit"
                        style="background:#111827;color:#fff;border:none;border-radius:8px;padding:10px 24px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">
                    Ganti Password
                </button>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    const input    = document.getElementById('avatar-input');
    const preview  = document.getElementById('avatar-preview');
    const initials = document.getElementById('avatar-initials');
    const filename = document.getElementById('avatar-filename');

    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        filename.textContent = file.name;
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (initials) initials.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush
</x-panel-layout>
