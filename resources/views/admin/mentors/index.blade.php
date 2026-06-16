<x-panel-layout>

<div class="panel-page-header">
    <div>
        <p class="panel-breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Verifikasi Mentor</p>
        <h1 class="panel-page-title">Verifikasi Mentor</h1>
    </div>
</div>

@if($pendingMentors->isEmpty())
<div class="panel-card">
    <div class="panel-empty" style="padding:64px 24px;">
        <svg width="40" height="40" fill="none" stroke="#d1d5db" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p style="font-weight:600;color:#6b7280;margin-bottom:4px;">Semua mentor sudah diverifikasi</p>
        <p style="color:#9ca3af;font-size:0.8125rem;">Tidak ada mentor yang menunggu verifikasi saat ini.</p>
    </div>
</div>
@else
<div style="background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;padding:14px 18px;display:flex;align-items:center;gap:10px;margin-bottom:20px;">
    <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <span style="font-size:0.875rem;color:#92400e;">
        Ada <strong>{{ $pendingMentors->total() }} mentor</strong> menunggu verifikasi.
    </span>
</div>

<div class="panel-card">
    <div class="panel-card-header">
        <span class="panel-card-title">Mentor Menunggu Verifikasi</span>
        <span style="font-size:0.8125rem;color:#9ca3af;">{{ $pendingMentors->total() }} akun</span>
    </div>
    <table class="panel-table">
        <thead>
            <tr>
                <th>Mentor</th>
                <th>Email</th>
                <th>Alasan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingMentors as $mentor)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:32px;height:32px;border-radius:50%;background:#f3e8ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.75rem;font-weight:700;color:#7c3aed;">
                            {{ strtoupper(substr($mentor->name, 0, 1)) }}
                        </div>
                        <span style="font-weight:500;color:#111827;">{{ $mentor->name }}</span>
                    </div>
                </td>
                <td style="color:#6b7280;font-size:0.8125rem;">{{ $mentor->email }}</td>
                <td style="color:#6b7280;font-size:0.8125rem;max-width:220px;">
                    {{ $mentor->mentor_reason ? Str::limit($mentor->mentor_reason, 60) : '-' }}
                </td>
                <td style="color:#9ca3af;font-size:0.8125rem;">{{ $mentor->created_at->timezone('Asia/Jakarta')->format('d M Y') }}</td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <form method="POST" action="{{ route('admin.mentors.approve', $mentor) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-register btn-sm" style="background:#16a34a;font-size:0.8125rem;padding:5px 14px;">
                                Setujui
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.mentors.reject', $mentor) }}" onsubmit="return confirm('Tolak mentor {{ addslashes($mentor->name) }}? Akun akan dikembalikan menjadi siswa.')">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-danger btn-sm">Tolak</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($pendingMentors->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f3f4f6;">
        {{ $pendingMentors->links() }}
    </div>
    @endif
</div>
@endif

</x-panel-layout>
