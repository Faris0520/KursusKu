<x-panel-layout>
    <div style="display:flex;align-items:center;justify-content:center;min-height:60vh;">
        <div style="text-align:center;max-width:480px;padding:48px 32px;">
            <div style="width:72px;height:72px;border-radius:50%;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;">
                <svg width="36" height="36" fill="none" stroke="#2563eb" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 style="font-size:1.5rem;font-weight:700;color:#111827;margin-bottom:12px;">Akun Sedang Diverifikasi</h1>
            <p style="font-size:0.9375rem;color:#6b7280;line-height:1.65;margin-bottom:8px;">
                Terima kasih sudah mendaftar sebagai mentor di <strong style="color:#111827;">{{ config('app.name') }}</strong>.
            </p>
            <p style="font-size:0.9375rem;color:#6b7280;line-height:1.65;margin-bottom:32px;">
                Akun kamu sedang dalam proses verifikasi oleh admin. Kamu akan mendapatkan akses penuh setelah akun disetujui. Proses ini biasanya memakan waktu 1&times;24 jam.
            </p>
            <div style="background:#f9fafb;border:1px solid #f0f0f0;border-radius:10px;padding:16px 20px;text-align:left;margin-bottom:32px;">
                <p style="font-size:0.8125rem;font-weight:600;color:#374151;margin-bottom:4px;">Informasi Akun</p>
                <p style="font-size:0.875rem;color:#6b7280;">{{ auth()->user()->name }}</p>
                <p style="font-size:0.875rem;color:#6b7280;">{{ auth()->user()->email }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="padding:10px 24px;background:#fff;border:1.5px solid #e5e7eb;border-radius:6px;font-size:0.875rem;font-weight:600;color:#374151;cursor:pointer;">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</x-panel-layout>
