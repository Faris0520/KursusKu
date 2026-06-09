<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-2">{{ $quiz->title }}</h1>
            <p class="text-gray-500 mb-8">{{ $quiz->questions->count() }} soal</p>

            <form method="POST" action="{{ route('siswa.quiz.submit', [$course, $quiz]) }}">
                @csrf

                @foreach($quiz->questions as $i => $question)
                <div class="bg-white p-6 rounded-lg shadow mb-4">
                    <p class="font-medium mb-4">{{ $i + 1 }}. {{ $question->question_text }}</p>

                    @foreach(['a', 'b', 'c', 'd'] as $option)
                    <label class="flex items-center gap-3 p-2 rounded hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="text-indigo-600">
                        <span>{{ strtoupper($option) }}. {{ $question->{'option_' . $option} }}</span>
                    </label>
                    @endforeach
                </div>
                @endforeach

                <button type="submit" class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                    Submit Jawaban
                </button>
            </form>
        </div>
    </div>
</x-app-layout>