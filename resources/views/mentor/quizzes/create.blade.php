<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> /
        <a href="{{ route('mentor.quizzes.index', $course) }}">Quiz</a> /
        <a href="{{ route('mentor.questions.index', [$course, $quiz]) }}">{{ $quiz->title }}</a> / Tambah Soal
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Tambah Soal</h1>

    <div class="panel-card" style="max-width:680px;">
        <div class="panel-card-body">
            <form method="POST" action="{{ route('mentor.questions.store', [$course, $quiz]) }}">
                @csrf

                <div class="panel-form-group">
                    <label class="panel-form-label" for="question_text">Pertanyaan</label>
                    <textarea class="panel-form-textarea" id="question_text" name="question_text" rows="3" required>{{ old('question_text') }}</textarea>
                    @error('question_text')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                <div class="panel-form-group">
                    <label class="panel-form-label" for="option_{{ $key }}">Opsi {{ $label }}</label>
                    <input class="panel-form-input" id="option_{{ $key }}" name="option_{{ $key }}"
                           value="{{ old('option_' . $key) }}" required>
                    @error('option_' . $key)<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>
                @endforeach

                <div class="panel-form-group">
                    <label class="panel-form-label" for="correct_answer">Jawaban Benar</label>
                    <select class="panel-form-select" id="correct_answer" name="correct_answer" required>
                        <option value="a" @selected(old('correct_answer') === 'a')>A</option>
                        <option value="b" @selected(old('correct_answer') === 'b')>B</option>
                        <option value="c" @selected(old('correct_answer') === 'c')>C</option>
                        <option value="d" @selected(old('correct_answer') === 'd')>D</option>
                    </select>
                </div>

                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn-register">Simpan Soal</button>
                    <a href="{{ route('mentor.questions.index', [$course, $quiz]) }}" class="btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>