<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Riwayat Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kursus</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($transactions as $trx)
                        <tr>
                            <td class="px-6 py-4">{{ $trx->course->title }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full
                                    {{ $trx->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $trx->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $trx->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $trx->status === 'expired' ? 'bg-gray-100 text-gray-800' : '' }}
                                ">{{ ucfirst($trx->status) }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $transactions->links() }}</div>
        </div>
    </div>
</x-app-layout>