<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Users</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_users'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Kursus</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_courses'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Enrollment</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_enrollments'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Transaksi Sukses</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_transactions'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Revenue</h3>
                    <p class="text-3xl font-bold">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Mentor Pending</h3>
                    <p class="text-3xl font-bold">{{ $stats['pending_mentors'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>