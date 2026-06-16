<x-panel-layout>
<div style="max-width:720px;margin:0 auto;padding:32px 16px;">
    <div style="margin-bottom:24px;">
        <a href="{{ route('courses.show', $course->slug) }}"
           style="display:inline-flex;align-items:center;gap:6px;font-size:0.875rem;color:#6b7280;text-decoration:none;">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke kursus
        </a>
    </div>

    <h1 style="font-size:1.375rem;font-weight:700;color:#111827;margin:0 0 24px;">Konfirmasi Pembayaran</h1>

    <div style="display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start;">

        <!-- Detail Kursus -->
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;">
            @if($course->thumbnail)
                <div style="width:100%;aspect-ratio:16/9;overflow:hidden;">
                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                         style="width:100%;height:100%;object-fit:cover;">
                </div>
            @endif

            <div style="padding:24px;">
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                    <span style="font-size:0.75rem;font-weight:600;background:#eff6ff;color:#2563eb;padding:3px 10px;border-radius:999px;">
                        {{ $course->category->name ?? 'Kursus' }}
                    </span>
                </div>

                <h2 style="font-size:1.125rem;font-weight:700;color:#111827;margin:0 0 6px;">{{ $course->title }}</h2>
                <p style="font-size:0.875rem;color:#6b7280;margin:0 0 20px;">
                    oleh <strong style="color:#374151;">{{ $course->mentor->name }}</strong>
                </p>

                <div style="display:flex;gap:20px;padding-top:16px;border-top:1px solid #f3f4f6;">
                    <div style="display:flex;align-items:center;gap:6px;font-size:0.8125rem;color:#6b7280;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        {{ $course->lessons->count() }} materi
                    </div>
                    <div style="display:flex;align-items:center;gap:6px;font-size:0.8125rem;color:#6b7280;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        {{ $course->enrollments_count ?? 0 }} siswa
                    </div>
                    @if($course->reviews_avg_rating)
                    <div style="display:flex;align-items:center;gap:6px;font-size:0.8125rem;color:#6b7280;">
                        <svg width="15" height="15" fill="#f59e0b" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        {{ number_format($course->reviews_avg_rating, 1) }}/5
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div style="background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;">
            <h3 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 20px;">Ringkasan Pembayaran</h3>

            <div style="display:flex;justify-content:space-between;font-size:0.875rem;color:#374151;margin-bottom:10px;">
                <span>Harga kursus</span>
                <span>Rp {{ number_format($course->price, 0, ',', '.') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:0.875rem;color:#374151;margin-bottom:16px;">
                <span>Biaya layanan</span>
                <span>Rp 0</span>
            </div>

            <div style="border-top:1px solid #f3f4f6;padding-top:16px;display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                <span style="font-size:0.9375rem;font-weight:600;color:#111827;">Total</span>
                <span style="font-size:1.25rem;font-weight:700;color:#2563eb;">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
            </div>

            <button id="pay-button"
                    style="width:100%;background:#2563eb;color:#fff;border:none;border-radius:8px;padding:13px;font-size:0.9375rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;transition:background .15s;">
                Bayar Sekarang
            </button>

            <div id="order-id-box" style="display:none;margin-top:16px;padding:12px;background:#f9fafb;border-radius:8px;">
                <p style="font-size:0.75rem;color:#9ca3af;margin:0 0 4px;font-weight:500;">ID Pesanan</p>
                <p id="order-id-text" style="font-size:0.8125rem;color:#374151;margin:0;word-break:break-all;font-family:monospace;"></p>
            </div>

            <div style="display:flex;align-items:center;gap:6px;margin-top:14px;justify-content:center;">
                <svg width="14" height="14" fill="none" stroke="#9ca3af" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <span style="font-size:0.75rem;color:#9ca3af;">Pembayaran aman via Midtrans</span>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const btn = document.getElementById('pay-button');

    btn.addEventListener('click', async function () {
        btn.disabled = true;
        btn.textContent = 'Memuat...';

        try {
            const res = await fetch('{{ route("transaction.initiate", $course) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            });

            const data = await res.json();

            if (!res.ok) {
                alert(data.error ?? 'Terjadi kesalahan. Silakan coba lagi.');
                btn.disabled = false;
                btn.textContent = 'Bayar Sekarang';
                return;
            }

            document.getElementById('order-id-text').textContent = data.order_id;
            document.getElementById('order-id-box').style.display = 'block';

            snap.pay(data.snap_token, {
                onSuccess: function () { window.location.href = '{{ route("payment.success", $course->slug) }}'; },
                onPending: function () { window.location.href = '{{ route("transactions.history") }}'; },
                onError:   function () { window.location.href = '{{ route("payment.failed", $course->slug) }}'; },
                onClose:   function () {
                    btn.disabled = false;
                    btn.textContent = 'Bayar Sekarang';
                    window.location.href = '{{ route("payment.failed", $course->slug) }}';
                }
            });
        } catch (e) {
            alert('Gagal menghubungi server. Periksa koneksi dan coba lagi.');
            btn.disabled = false;
            btn.textContent = 'Bayar Sekarang';
        }
    });

    btn.addEventListener('mouseover', function() { if (!btn.disabled) btn.style.background = '#1d4ed8'; });
    btn.addEventListener('mouseout',  function() { if (!btn.disabled) btn.style.background = '#2563eb'; });
</script>
@endpush
</x-panel-layout>
