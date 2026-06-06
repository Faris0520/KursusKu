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
                <a href="{{ route('mentor.courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Buat Kursus</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($courses as $course)
                <div class="bg-white p-4 rounded-lg shadow">
                    <h4 class="font-semibold">{{ $course->title }}</h4>
                    <p class="text-sm text-gray-500">{{ $course->enrollments_count }} siswa</p>
                    <span class="text-xs px-2 py-1 rounded-full {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($course->status) }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>