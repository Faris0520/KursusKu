<x-app-layout>
    <div class="flex h-[calc(100vh-65px)]">
        <!-- Sidebar Materi -->
        <aside class="w-72 bg-white border-r overflow-y-auto hidden md:block">
            <div class="p-4 border-b">
                <h3 class="font-bold text-sm">{{ $course->title }}</h3>
            </div>
            <nav class="p-2">
                @foreach($lessons as $lesson)
                <a href="{{ route('siswa.learn', [$course->slug, $lesson]) }}"
                   class="block px-3 py-2 rounded text-sm {{ $lesson->id === $currentLesson->id ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }}">
                    <span class="text-gray-400 mr-2">{{ $lesson->order }}.</span>
                    {{ $lesson->title }}
                </a>
                @endforeach
            </nav>

            <!-- Quiz Links -->
            @if($course->quizzes->count())
            <div class="p-4 border-t">
                <h4 class="font-bold text-sm mb-2">Quiz</h4>
                @foreach($course->quizzes as $quiz)
                <a href="{{ route('siswa.quiz.show', [$course, $quiz]) }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded">
                    {{ $quiz->title }}
                </a>
                @endforeach
            </div>
            @endif
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $currentLesson->title }}</h1>

            <!-- YouTube Embed -->
            <div class="aspect-video mb-6">
                <iframe
                    src="{{ str_replace('watch?v=', 'embed/', $currentLesson->youtube_url) }}"
                    class="w-full h-full rounded-lg"
                    frameborder="0"
                    allowfullscreen>
                </iframe>
            </div>

            <!-- PDF Download -->
            @if($currentLesson->pdf_path)
            <div class="mb-6">
                <a href="{{ asset('storage/' . $currentLesson->pdf_path) }}" target="_blank"
                   class="inline-flex items-center gap-2 bg-gray-100 px-4 py-2 rounded hover:bg-gray-200">
                    Download PDF Materi
                </a>
            </div>
            @endif

            <!-- Navigation -->
            <div class="flex justify-between mt-8">
                @php
                    $prevLesson = $lessons->where('order', '<', $currentLesson->order)->last();
                    $nextLesson = $lessons->where('order', '>', $currentLesson->order)->first();
                @endphp

                @if($prevLesson)
                    <a href="{{ route('siswa.learn', [$course->slug, $prevLesson]) }}" class="text-indigo-600 hover:underline">← Sebelumnya</a>
                @else
                    <span></span>
                @endif

                @if($nextLesson)
                    <a href="{{ route('siswa.learn', [$course->slug, $nextLesson]) }}" class="text-indigo-600 hover:underline">Selanjutnya →</a>
                @endif
            </div>

            <!-- Review Form -->
            @if(!$course->reviews()->where('user_id', auth()->id())->exists())
            <div class="mt-8 bg-white p-6 rounded-lg shadow">
                <h3 class="font-bold mb-4">Beri Review</h3>
                <form method="POST" action="{{ route('siswa.review.store', $course) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Rating</label>
                        <select name="rating" class="rounded-md border-gray-300">
                            <option value="5">★★★★★ (5)</option>
                            <option value="4">★★★★☆ (4)</option>
                            <option value="3">★★★☆☆ (3)</option>
                            <option value="2">★★☆☆☆ (2)</option>
                            <option value="1">★☆☆☆☆ (1)</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Komentar (opsional)</label>
                        <textarea name="comment" rows="3" class="w-full rounded-md border-gray-300" placeholder="Tulis pendapatmu..."></textarea>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Kirim Review</button>
                </form>
            </div>
            @endif
        </main>
    </div>
</x-app-layout>