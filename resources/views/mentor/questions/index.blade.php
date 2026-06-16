<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> /
        <a href="{{ route('mentor.quizzes.index', $course) }}">Quiz</a> /
        {{ $quiz->title }}
    </div>

    <div class="panel-page-header" style="margin-top:8px;">
        <h1 class="panel-page-title">Soal - {{ $quiz->title }}</h1>
        <a href="{{ route('mentor.questions.create', [$course, $quiz]) }}" class="btn-register">+ Tambah Soal</a>
    </div>

    <div>
        @forelse($questions as $i => $question)
        <div class="panel-list-item">
            <div class="panel-list-item-info">
                <p class="panel-list-item-title">{{ $i + 1 }}. {{ $question->question_text }}</p>
                <p class="panel-list-item-meta">
                    A: {{ $question->option_a }} &bull; B: {{ $question->option_b }} &bull;
                    C: {{ $question->option_c }} &bull; D: {{ $question->option_d }} &bull;
                    Jawaban: <strong>{{ strtoupper($question->correct_answer) }}</strong>
                </p>
            </div>
            <div class="panel-list-item-actions">
                <a href="{{ route('mentor.questions.edit', [$course, $quiz, $question]) }}" class="btn-outline btn-sm">Edit</a>
                <form method="POST" action="{{ route('mentor.questions.destroy', [$course, $quiz, $question]) }}"
                      onsubmit="return confirm('Yakin hapus soal ini?')" style="margin:0">
                    @csrf @method('DELETE')
                    <button class="btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="panel-empty">Belum ada soal. Tambahkan soal pertama.</div>
        @endforelse
    </div>
</x-panel-layout>