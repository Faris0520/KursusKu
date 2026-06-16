<x-panel-layout>
<h1 class="panel-page-title">Dashboard</h1>
<p style="font-size:0.875rem;color:#6b7280;margin-bottom:24px;">Selamat datang kembali, {{ auth()->user()->name }}.</p>

{{-- Stat Cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
    @php
    $cards = [
        ['label' => 'Total Pengguna',   'value' => $stats['total_users'],       'sub' => $stats['total_siswa'].' siswa · '.$stats['total_mentors'].' mentor', 'color' => '#2563eb', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['label' => 'Total Kursus',     'value' => $stats['total_courses'],     'sub' => $stats['published_courses'].' dipublikasi', 'color' => '#7c3aed', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['label' => 'Total Enrollments','value' => $stats['total_enrollments'], 'sub' => 'dari semua kursus', 'color' => '#0891b2', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'Total Pendapatan', 'value' => 'Rp '.number_format($stats['total_revenue'],0,',','.'), 'sub' => 'dari transaksi berhasil', 'color' => '#16a34a', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    @endphp
    @foreach($cards as $card)
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:0.8125rem;font-weight:500;color:#6b7280;">{{ $card['label'] }}</span>
            <div style="width:36px;height:36px;border-radius:8px;background:{{ $card['color'] }}1a;display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" stroke="{{ $card['color'] }}" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
        </div>
        <div style="font-size:1.5rem;font-weight:700;color:#111827;margin-bottom:4px;">{{ $card['value'] }}</div>
        <div style="font-size:0.75rem;color:#9ca3af;">{{ $card['sub'] }}</div>
    </div>
    @endforeach
</div>

@if($stats['pending_mentors'] > 0)
<div style="background:#fffbeb;border:1px solid #fcd34d;border-radius:10px;padding:14px 18px;display:flex;align-items:center;gap:10px;margin-bottom:24px;">
    <svg width="18" height="18" fill="none" stroke="#d97706" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <span style="font-size:0.875rem;color:#92400e;font-weight:500;">
        Ada <strong>{{ $stats['pending_mentors'] }} mentor</strong> menunggu verifikasi.
    </span>
    <a href="{{ route('admin.mentors.index') }}" style="margin-left:auto;font-size:0.8125rem;font-weight:600;color:#d97706;">Lihat →</a>
</div>
@endif

{{-- Tables --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px;">

    {{-- Transaksi Terbaru --}}
    <div class="panel-card">
        <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:0.9375rem;font-weight:700;color:#111827;">Transaksi Terbaru</span>
        </div>
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Kursus</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $trx)
                <tr>
                    <td>{{ $trx->user->name }}</td>
                    <td style="color:#6b7280;font-size:0.8125rem;">{{ Str::limit($trx->course->title, 24) }}</td>
                    <td style="font-weight:600;color:#16a34a;">Rp {{ number_format($trx->amount,0,',','.') }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="panel-empty">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Kursus Terpopuler --}}
    <div class="panel-card">
        <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
            <span style="font-size:0.9375rem;font-weight:700;color:#111827;">Kursus Terpopuler</span>
        </div>
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Kursus</th>
                    <th>Mentor</th>
                    <th>Siswa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCourses as $course)
                <tr>
                    <td style="font-weight:500;">{{ Str::limit($course->title, 24) }}</td>
                    <td style="color:#6b7280;font-size:0.8125rem;">{{ $course->mentor->name ?? '-' }}</td>
                    <td>
                        <span style="background:#eff6ff;color:#2563eb;font-size:0.75rem;font-weight:600;padding:2px 8px;border-radius:999px;">
                            {{ $course->enrollments_count }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="panel-empty">Belum ada kursus.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pengguna Terbaru --}}
<div class="panel-card">
    <div style="padding:16px 20px;border-bottom:1px solid #f3f4f6;display:flex;justify-content:space-between;align-items:center;">
        <span style="font-size:0.9375rem;font-weight:700;color:#111827;">Pengguna Terbaru</span>
        <a href="{{ route('admin.users.index') }}" style="font-size:0.8125rem;color:#2563eb;font-weight:500;">Lihat Semua</a>
    </div>
    <table class="panel-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentUsers as $user)
            <tr>
                <td style="font-weight:500;display:flex;align-items:center;gap:8px;">
                    <div style="width:28px;height:28px;border-radius:50%;background:#e0e7ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.75rem;font-weight:700;color:#2563eb;">
                        {{ strtoupper(substr($user->name,0,1)) }}
                    </div>
                    {{ $user->name }}
                </td>
                <td style="color:#6b7280;font-size:0.8125rem;">{{ $user->email }}</td>
                <td>
                    @php $roleColor = ['admin'=>'#dc2626','mentor'=>'#7c3aed','siswa'=>'#2563eb'][$user->role] ?? '#6b7280'; @endphp
                    <span style="background:{{ $roleColor }}1a;color:{{ $roleColor }};font-size:0.75rem;font-weight:600;padding:2px 10px;border-radius:999px;text-transform:capitalize;">
                        {{ $user->role }}
                    </span>
                </td>
                <td style="color:#9ca3af;font-size:0.8125rem;">{{ $user->created_at->timezone('Asia/Jakarta')->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</x-panel-layout>
