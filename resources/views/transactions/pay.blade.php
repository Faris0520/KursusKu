<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-2xl font-bold mb-4">Pembayaran</h1>
            <p class="text-gray-600 mb-2">Kursus: {{ $course->title }}</p>
            <p class="text-3xl font-bold mb-8">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>

            <button id="pay-button" class="bg-indigo-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-indigo-700">
                Bayar Sekarang
            </button>

            <p class="mt-4 text-sm text-gray-500">Kamu akan diarahkan ke halaman pembayaran Midtrans</p>
        </div>
    </div>

    @push('scripts')
    <script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route("siswa.dashboard") }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route("transactions.history") }}';
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    window.location.href = '{{ route("courses.show", $course->slug) }}';
                },
                onClose: function() {
                    window.location.href = '{{ route("courses.show", $course->slug) }}';
                }
            });
        });
    </script>
    @endpush
</x-app-layout>