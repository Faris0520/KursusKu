<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> /
        Quiz
    </div>

    <div class="panel-page-header" style="margin-top:8px;">
        <h1 class="panel-page-title">Quiz &mdash; {{ $course->title }}</h1>
        <a href="{{ route('mentor.quizzes.create', $course) }}" class="btn-register">+ Tambah Quiz</a>
    </div>

    <div>
        @forelse($quizzes as $quiz)
        <div class="panel-list-item">
            <div class="panel-list-item-info">
                <p class="panel-list-item-title">{{ $quiz->title }}</p>
                <p class="panel-list-item-meta">{{ $quiz->questions_count }} soal</p>
            </div>
            <div class="panel-list-item-actions">
                <a href="{{ route('mentor.questions.index', [$course, $quiz]) }}" class="btn-outline btn-sm">Kelola Soal</a>
                <a href="{{ route('mentor.quizzes.edit', [$course, $quiz]) }}" class="btn-outline btn-sm">Edit</a>
                <form method="POST" action="{{ route('mentor.quizzes.destroy', [$course, $quiz]) }}"
                      onsubmit="return confirm('Yakin hapus quiz ini beserta semua soalnya?')" style="margin:0">
                    @csrf @method('DELETE')
                    <button class="btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="panel-empty">Belum ada quiz. Tambahkan quiz pertama untuk kursus ini.</div>
        @endforelse
    </div>
</x-panel-layout>
