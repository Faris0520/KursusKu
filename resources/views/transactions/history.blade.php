<x-panel-layout>
    <h1 class="panel-page-title" style="margin-bottom:24px;">Riwayat Transaksi</h1>

    <div class="panel-card">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Kursus</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td style="font-weight:600;">{{ $trx->course->title }}</td>
                    <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badgeMap = ['paid'=>'badge-paid','pending'=>'badge-pending','failed'=>'badge-failed','expired'=>'badge-expired'];
                        @endphp
                        <span class="badge {{ $badgeMap[$trx->status] ?? '' }}">{{ ucfirst($trx->status) }}</span>
                    </td>
                    <td style="color:#9ca3af;">{{ $trx->created_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="panel-empty">Belum ada transaksi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $transactions->links() }}</div>
</x-panel-layout>