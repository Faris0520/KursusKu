<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Dashboard Siswa</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Kursus Saya -->
            <h3 class="text-lg font-bold mb-4">Kursus Saya</h3>
            @if($enrolledCourses->isEmpty())
                <p class="text-gray-500 mb-8">Belum ada kursus. <a href="{{ route('courses.index') }}" class="text-indigo-600 hover:underline">Jelajahi kursus</a></p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    @foreach($enrolledCourses as $enrollment)
                    <div class="bg-white rounded-lg shadow p-4">
                        <h4 class="font-semibold">{{ $enrollment->course->title }}</h4>
                        <p class="text-sm text-gray-500">{{ $enrollment->course->mentor->name }}</p>
                        <p class="text-xs text-gray-400 mt-1">Enrolled: {{ $enrollment->enrolled_at->format('d M Y') }}</p>
                        <a href="{{ route('siswa.learn', $enrollment->course->slug) }}" class="mt-3 inline-block text-indigo-600 text-sm font-medium hover:underline">
                            Lanjut Belajar →
                        </a>
                    </div>
                    @endforeach
                </div>
            @endif

            <!-- Riwayat Transaksi -->
            <h3 class="text-lg font-bold mb-4">Transaksi Terakhir</h3>
            @if($recentTransactions->isEmpty())
                <p class="text-gray-500">Belum ada transaksi.</p>
            @else
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Kursus</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Jumlah</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentTransactions as $trx)
                            <tr>
                                <td class="px-4 py-3 text-sm">{{ $trx->course->title }}</td>
                                <td class="px-4 py-3 text-sm">Rp {{ number_format($trx->amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $trx->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}
                                    ">{{ ucfirst($trx->status) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>