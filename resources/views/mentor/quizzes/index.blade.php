<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Quiz: {{ $course->title }}</h2>
            <a href="{{ route('mentor.quizzes.create', $course) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Buat Quiz</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-3">
                @forelse($quizzes as $quiz)
                <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                    <div>
                        <p class="font-medium">{{ $quiz->title }}</p>
                        <p class="text-sm text-gray-500">{{ $quiz->questions_count }} soal</p>
                    </div>
                    <div class="flex gap-2 text-sm">
                        <a href="{{ route('mentor.questions.index', [$course, $quiz]) }}" class="text-indigo-600 hover:underline">Kelola Soal</a>
                        <a href="{{ route('mentor.quizzes.edit', [$course, $quiz]) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('mentor.quizzes.destroy', [$course, $quiz]) }}" onsubmit="return confirm('Yakin hapus?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-8">Belum ada quiz.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>