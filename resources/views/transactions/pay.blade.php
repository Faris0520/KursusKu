<x-panel-layout>
    <div class="payment-card">
        <p style="font-size:0.875rem;color:#9ca3af;margin-bottom:4px;">Pembayaran untuk</p>
        <h1 style="font-size:1.25rem;font-weight:700;color:#111827;margin-bottom:4px;">{{ $course->title }}</h1>
        <p class="payment-amount">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>

        <button id="pay-button" class="btn-register"
                style="width:100%;padding:12px;font-size:0.9375rem;">
            Bayar Sekarang
        </button>
        <p style="margin-top:12px;font-size:0.8125rem;color:#9ca3af;">
            Kamu akan diarahkan ke halaman pembayaran Midtrans
        </p>
    </div>

    @push('scripts')
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function () { window.location.href = '{{ route("siswa.dashboard") }}'; },
                onPending: function () { window.location.href = '{{ route("transactions.history") }}'; },
                onError:   function () { window.location.href = '{{ route("courses.show", $course->slug) }}'; },
                onClose:   function () { window.location.href = '{{ route("courses.show", $course->slug) }}'; }
            });
        });
    </script>
    @endpush
</x-panel-layout>