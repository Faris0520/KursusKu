<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Mentor Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Kursus</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_courses'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Published</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['published_courses'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Draft</h3>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['draft_courses'] }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-gray-500 text-sm">Total Siswa</h3>
                    <p class="text-3xl font-bold">{{ $stats['total_students'] }}</p>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">Kursus Saya</h3>
                @can('create-course')
                <a href="{{ route('mentor.courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Buat Kursus</a>
                @endcan
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($courses as $course)
                <a href="{{ route('mentor.courses.show', $course) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md hover:ring-1 hover:ring-indigo-200 transition">
                    <h4 class="font-semibold">{{ $course->title }}</h4>
                    <p class="text-sm text-gray-500">{{ $course->enrollments_count }} siswa</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs px-2 py-1 rounded-full {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                        <span class="text-xs text-indigo-600">Lihat detail &rarr;</span>
                    </div>
                </a>
                @empty
                <p class="text-gray-500 col-span-3">Belum ada kursus. Klik "Buat Kursus" untuk memulai.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>