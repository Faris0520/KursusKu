<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Materi: {{ $course->title }}</h2>
            <a href="{{ route('mentor.lessons.create', $course) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Tambah Materi</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-3">
                @forelse($lessons as $lesson)
                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <span class="text-gray-400 font-mono w-8">{{ $lesson->order }}</span>
                        <div>
                            <p class="font-medium">{{ $lesson->title }}</p>
                            <p class="text-sm text-gray-500">{{ $lesson->youtube_url }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2 text-sm">
                        <a href="{{ route('mentor.lessons.edit', [$course, $lesson]) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('mentor.lessons.destroy', [$course, $lesson]) }}" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada materi. Tambahkan materi pertama.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>