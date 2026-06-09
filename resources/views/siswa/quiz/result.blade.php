<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold">Hasil Quiz: {{ $quiz->title }}</h1>
                <p class="text-5xl font-bold mt-4 {{ $attempt->percentage() >= 70 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $attempt->score }}/{{ $attempt->total_questions }}
                </p>
                <p class="text-gray-500 mt-2">{{ number_format($attempt->percentage(), 0) }}% benar</p>
            </div>

            @foreach($results as $i => $result)
            <div class="bg-white p-6 rounded-lg shadow mb-4 border-l-4 {{ $result['is_correct'] ? 'border-green-500' : 'border-red-500' }}">
                <p class="font-medium mb-2">{{ $i + 1 }}. {{ $result['question']->question_text }}</p>
                <p class="text-sm">
                    Jawaban kamu: <span class="font-medium">{{ strtoupper($result['user_answer'] ?? '-') }}</span>
                    @unless($result['is_correct'])
                        | Jawaban benar: <span class="font-medium text-green-600">{{ strtoupper($result['question']->correct_answer) }}</span>
                    @endunless
                </p>
            </div>
            @endforeach

            <div class="flex gap-4 mt-6">
                <a href="{{ route('siswa.learn', $course->slug) }}" class="bg-gray-200 px-6 py-2 rounded-lg hover:bg-gray-300">Kembali ke Materi</a>
                <a href="{{ route('siswa.quiz.show', [$course, $quiz]) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">Coba Lagi</a>
            </div>
        </div>
    </div>
</x-app-layout>