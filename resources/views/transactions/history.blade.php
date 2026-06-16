<x-panel-layout>
<h1 class="panel-page-title" style="margin-bottom:24px;">Riwayat Transaksi</h1>

<div class="panel-card">
    <table class="panel-table">
        <thead>
            <tr>
                <th style="width:36px;"></th>
                <th>Kursus</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
            @php
                $badgeMap = ['paid'=>'badge-paid','pending'=>'badge-pending','failed'=>'badge-failed','expired'=>'badge-expired'];
                $statusLabel = ['paid'=>'Berhasil','pending'=>'Menunggu','failed'=>'Gagal','expired'=>'Kedaluwarsa'];
                $statusDesc = [
                    'paid'    => 'Pembayaran telah diterima. Kamu sudah bisa mengakses kursus ini.',
                    'pending' => 'Pembayaran belum diselesaikan. Klik "Lanjut Bayar" untuk menyelesaikan pembayaran.',
                    'failed'  => 'Pembayaran gagal atau ditolak. Kamu bisa membeli kursus ini kembali.',
                    'expired' => 'Batas waktu pembayaran telah habis. Buat pesanan baru untuk melanjutkan.',
                ];
            @endphp
            <tr class="trx-row" style="cursor:pointer;" onclick="toggleDetail('detail-{{ $trx->id }}', this)">
                <td>
                    <svg class="chevron-icon" style="width:16px;height:16px;color:#9ca3af;transition:transform .2s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </td>
                <td style="font-weight:600;">{{ $trx->course->title }}</td>
                <td>Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                <td>
                    <span class="badge {{ $badgeMap[$trx->status] ?? '' }}">{{ $statusLabel[$trx->status] ?? ucfirst($trx->status) }}</span>
                </td>
                <td style="color:#9ca3af;">{{ $trx->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</td>
            </tr>
            <tr id="detail-{{ $trx->id }}" style="display:none;">
                <td colspan="5" style="padding:0;">
                    <div style="background:#f9fafb;border-top:1px solid #f3f4f6;padding:20px 24px;display:flex;gap:32px;align-items:flex-start;flex-wrap:wrap;">
                        <div style="flex:1;min-width:200px;">
                            <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 2px;font-weight:500;">ID Pesanan</p>
                            <p style="font-size:0.8125rem;color:#374151;margin:0 0 14px;font-family:monospace;word-break:break-all;">{{ $trx->midtrans_order_id }}</p>

                            <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 2px;font-weight:500;">Kursus</p>
                            <p style="font-size:0.8125rem;color:#374151;margin:0 0 14px;">
                                <a href="{{ route('courses.show', $trx->course->slug) }}" style="color:#2563eb;text-decoration:none;">{{ $trx->course->title }}</a>
                            </p>

                            @if($trx->paid_at)
                            <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 2px;font-weight:500;">Dibayar pada</p>
                            <p style="font-size:0.8125rem;color:#374151;margin:0 0 14px;">{{ $trx->paid_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB</p>
                            @endif

                            @if($trx->midtrans_transaction_id)
                            <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 2px;font-weight:500;">ID Transaksi Midtrans</p>
                            <p style="font-size:0.8125rem;color:#374151;margin:0;font-family:monospace;">{{ $trx->midtrans_transaction_id }}</p>
                            @endif
                        </div>

                        <div style="flex:1;min-width:200px;">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                                @php
                                    $iconColor = ['paid'=>'#16a34a','pending'=>'#d97706','failed'=>'#dc2626','expired'=>'#6b7280'];
                                @endphp
                                <svg style="width:16px;height:16px;color:{{ $iconColor[$trx->status] ?? '#6b7280' }};flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($trx->status === 'paid')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @elseif($trx->status === 'pending')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @endif
                                </svg>
                                <span style="font-size:0.875rem;color:#374151;">{{ $statusDesc[$trx->status] ?? '' }}</span>
                            </div>

                            @if($trx->status === 'pending')
                            <button
                                onclick="event.stopPropagation(); resumePayment({{ $trx->id }}, '{{ $trx->course->slug }}')"
                                style="margin-top:12px;background:#2563eb;color:#fff;border:none;border-radius:7px;padding:9px 18px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;"
                                id="resume-btn-{{ $trx->id }}">
                                Lanjut Bayar
                            </button>
                            @elseif($trx->status === 'failed' || $trx->status === 'expired')
                            <a href="{{ route('courses.show', $trx->course->slug) }}"
                               style="display:inline-block;margin-top:12px;background:#f3f4f6;color:#374151;border-radius:7px;padding:9px 18px;font-size:0.875rem;font-weight:600;text-decoration:none;">
                                Beli Lagi
                            </a>
                            @elseif($trx->status === 'paid')
                            <a href="{{ route('siswa.learn', $trx->course->slug) }}"
                               style="display:inline-block;margin-top:12px;background:#16a34a;color:#fff;border-radius:7px;padding:9px 18px;font-size:0.875rem;font-weight:600;text-decoration:none;">
                                Buka Kursus
                            </a>
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="panel-empty">Belum ada transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div>{{ $transactions->links() }}</div>

@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function toggleDetail(id, row) {
    const detail = document.getElementById(id);
    const chevron = row.querySelector('.chevron-icon');
    const open = detail.style.display === 'table-row';
    detail.style.display = open ? 'none' : 'table-row';
    chevron.style.transform = open ? '' : 'rotate(90deg)';
}

async function resumePayment(transactionId, courseSlug) {
    const btn = document.getElementById('resume-btn-' + transactionId);
    btn.disabled = true;
    btn.textContent = 'Memuat...';

    try {
        const res = await fetch(`/transactions/${transactionId}/resume`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        });

        const data = await res.json();

        if (!res.ok) {
            alert(data.error ?? 'Terjadi kesalahan.');
            btn.disabled = false;
            btn.textContent = 'Lanjut Bayar';
            return;
        }

        snap.pay(data.snap_token, {
            onSuccess: function () { window.location.href = `/payment/${courseSlug}/success`; },
            onPending: function () { window.location.reload(); },
            onError:   function () { window.location.href = `/payment/${courseSlug}/failed`; },
            onClose:   function () {
                btn.disabled = false;
                btn.textContent = 'Lanjut Bayar';
            }
        });
    } catch (e) {
        alert('Gagal menghubungi server. Periksa koneksi dan coba lagi.');
        btn.disabled = false;
        btn.textContent = 'Lanjut Bayar';
    }
}
</script>
@endpush
</x-panel-layout>
