<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> /
        <a href="{{ route('mentor.quizzes.index', $course) }}">Quiz</a> /
        Tambah Quiz
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Tambah Quiz</h1>

    <div class="panel-card" style="max-width:560px;">
        <div class="panel-card-body">
            <form method="POST" action="{{ route('mentor.quizzes.store', $course) }}">
                @csrf

                <div class="panel-form-group">
                    <label class="panel-form-label" for="title">Judul Quiz</label>
                    <input class="panel-form-input" id="title" name="title"
                           value="{{ old('title') }}" placeholder="Contoh: Quiz Bab 1" required autofocus>
                    @error('title')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn-register">Simpan Quiz</button>
                    <a href="{{ route('mentor.quizzes.index', $course) }}" class="btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>
