<x-panel-layout>

<div class="panel-page-header">
    <div>
        <p class="panel-breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Transaksi</p>
        <h1 class="panel-page-title">Kelola Transaksi</h1>
    </div>
</div>

{{-- Stat Cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">
    @php
    $statCards = [
        ['label' => 'Total Transaksi',  'value' => $stats['total'],                                              'color' => '#2563eb', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['label' => 'Berhasil',         'value' => $stats['paid'],                                               'color' => '#16a34a', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Menunggu',         'value' => $stats['pending'],                                            'color' => '#d97706', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['label' => 'Total Pendapatan', 'value' => 'Rp '.number_format($stats['revenue'], 0, ',', '.'),          'color' => '#7c3aed', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ];
    @endphp
    @foreach($statCards as $card)
    <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
            <span style="font-size:0.8125rem;font-weight:500;color:#6b7280;">{{ $card['label'] }}</span>
            <div style="width:36px;height:36px;border-radius:8px;background:{{ $card['color'] }}1a;display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" stroke="{{ $card['color'] }}" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}"/>
                </svg>
            </div>
        </div>
        <div style="font-size:1.5rem;font-weight:700;color:#111827;">{{ $card['value'] }}</div>
    </div>
    @endforeach
</div>

{{-- Filter --}}
<div class="panel-card" style="margin-bottom:20px;">
    <div class="panel-card-body" style="padding:16px 20px;">
        <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama pengguna atau kursus..."
                class="panel-form-input"
                style="flex:1;min-width:200px;"
            >
            <select name="status" class="panel-form-select" style="width:180px;">
                <option value="">Semua Status</option>
                <option value="paid"    @selected(request('status') == 'paid')>Berhasil</option>
                <option value="pending" @selected(request('status') == 'pending')>Menunggu</option>
                <option value="failed"  @selected(request('status') == 'failed')>Gagal</option>
                <option value="expired" @selected(request('status') == 'expired')>Kedaluwarsa</option>
            </select>
            <button type="submit" class="btn-register btn-sm" style="height:36px;padding:0 18px;font-size:0.8125rem;">Filter</button>
            @if(request()->hasAny(['search','status']))
                <a href="{{ route('admin.transactions.index') }}" class="btn-outline btn-sm" style="height:36px;line-height:36px;padding:0 14px;">Reset</a>
            @endif
        </form>
    </div>
</div>

{{-- Table --}}
<div class="panel-card">
    <div class="panel-card-header">
        <span class="panel-card-title">Semua Transaksi</span>
        <span style="font-size:0.8125rem;color:#9ca3af;">{{ $transactions->total() }} transaksi</span>
    </div>
    <table class="panel-table">
        <thead>
            <tr>
                <th>Pengguna</th>
                <th>Kursus</th>
                <th>Order ID</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $badgeMap   = ['paid'=>'badge-paid','pending'=>'badge-pending','failed'=>'badge-failed','expired'=>'badge-expired'];
            $statusLabel = ['paid'=>'Berhasil','pending'=>'Menunggu','failed'=>'Gagal','expired'=>'Kedaluwarsa'];
            @endphp
            @forelse($transactions as $trx)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:30px;height:30px;border-radius:50%;background:#e0e7ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.75rem;font-weight:700;color:#2563eb;">
                            {{ strtoupper(substr($trx->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:500;color:#111827;font-size:0.875rem;">{{ $trx->user->name }}</div>
                            <div style="color:#9ca3af;font-size:0.75rem;">{{ $trx->user->email }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:0.875rem;color:#374151;">{{ Str::limit($trx->course->title, 30) }}</td>
                <td style="font-family:monospace;font-size:0.75rem;color:#9ca3af;">{{ $trx->midtrans_order_id ?? '-' }}</td>
                <td style="font-weight:600;color:#111827;">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                <td>
                    <span class="badge {{ $badgeMap[$trx->status] ?? '' }}">
                        {{ $statusLabel[$trx->status] ?? ucfirst($trx->status) }}
                    </span>
                </td>
                <td style="color:#9ca3af;font-size:0.8125rem;">
                    {{ $trx->created_at->timezone('Asia/Jakarta')->format('d M Y') }}
                    @if($trx->paid_at)
                        <div style="font-size:0.75rem;color:#16a34a;">Bayar: {{ $trx->paid_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }}</div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="panel-empty">Tidak ada transaksi yang ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($transactions->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f3f4f6;">
        {{ $transactions->withQueryString()->links() }}
    </div>
    @endif
</div>

</x-panel-layout>
