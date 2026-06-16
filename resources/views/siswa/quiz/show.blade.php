<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('siswa.dashboard') }}">Dashboard</a> /
        <a href="{{ route('siswa.learn', $course->slug) }}">{{ $course->title }}</a> /
        {{ $quiz->title }}
    </div>

    <div style="max-width:720px;margin-top:16px;">
        <div style="margin-bottom:24px;">
            <h1 style="font-size:1.375rem;font-weight:700;color:#111827;margin:0 0 4px;">{{ $quiz->title }}</h1>
            <p style="font-size:0.875rem;color:#6b7280;margin:0;">{{ $quiz->questions->count() }} soal &bull; Pilih satu jawaban untuk setiap soal</p>
        </div>

        <form method="POST" action="{{ route('siswa.quiz.submit', [$course, $quiz]) }}" id="quiz-form">
            @csrf

            @foreach($quiz->questions as $i => $question)
            <div class="panel-card" style="margin-bottom:12px;">
                <div class="panel-card-body">
                    <p style="font-weight:600;color:#111827;margin:0 0 14px;line-height:1.5;">
                        {{ $i + 1 }}. {{ $question->question_text }}
                    </p>

                    <div style="display:flex;flex-direction:column;gap:8px;">
                        @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                        <label style="display:flex;align-items:center;gap:10px;padding:10px 14px;border:1px solid #e5e7eb;border-radius:8px;cursor:pointer;transition:all .15s;"
                               onmouseover="this.style.borderColor='#2563eb';this.style.background='#eff6ff'"
                               onmouseout="if(!this.querySelector('input').checked){this.style.borderColor='#e5e7eb';this.style.background=''}">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}"
                                   style="accent-color:#2563eb;width:16px;height:16px;flex-shrink:0;"
                                   onchange="highlightSelected(this)">
                            <span style="font-size:0.9rem;color:#374151;">
                                <strong>{{ $label }}.</strong> {{ $question->{'option_' . $key} }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

            <div style="margin-top:20px;display:flex;gap:12px;align-items:center;">
                <button type="submit" class="btn-register" style="padding:12px 32px;font-size:0.95rem;">
                    Submit Jawaban
                </button>
                <a href="{{ route('siswa.learn', $course->slug) }}" class="btn-outline">Kembali ke Materi</a>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function highlightSelected(input) {
            const group = input.closest('div[style*="flex-direction:column"]');
            group.querySelectorAll('label').forEach(label => {
                label.style.borderColor = '#e5e7eb';
                label.style.background = '';
            });
            const selected = input.closest('label');
            selected.style.borderColor = '#2563eb';
            selected.style.background = '#eff6ff';
        }

        document.getElementById('quiz-form').addEventListener('submit', function (e) {
            const total = {{ $quiz->questions->count() }};
            const answered = this.querySelectorAll('input[type=radio]:checked').length;
            if (answered < total) {
                e.preventDefault();
                alert('Harap jawab semua soal sebelum submit. (' + answered + '/' + total + ' terjawab)');
            }
        });
    </script>
    @endpush
</x-panel-layout>
