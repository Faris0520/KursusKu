<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('siswa.dashboard') }}">Dashboard</a> /
        <a href="{{ route('siswa.learn', $course->slug) }}">{{ $course->title }}</a> /
        Hasil Quiz
    </div>

    <div style="max-width:720px;margin-top:16px;">

        {{-- Score Card --}}
        @php $pass = $attempt->percentage() >= 70; @endphp
        <div class="panel-card" style="margin-bottom:20px;text-align:center;padding:32px 24px;">
            <div style="width:80px;height:80px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;
                        background:{{ $pass ? '#dcfce7' : '#fee2e2' }};">
                @if($pass)
                <svg width="36" height="36" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
                @else
                <svg width="36" height="36" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                @endif
            </div>

            <p style="font-size:0.875rem;font-weight:600;text-transform:uppercase;letter-spacing:.05em;
                       color:{{ $pass ? '#16a34a' : '#dc2626' }};margin:0 0 8px;">
                {{ $pass ? 'Lulus' : 'Belum Lulus' }}
            </p>
            <h1 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 16px;">{{ $quiz->title }}</h1>

            <div style="display:flex;justify-content:center;gap:40px;flex-wrap:wrap;">
                <div>
                    <p style="font-size:2.5rem;font-weight:800;color:{{ $pass ? '#16a34a' : '#dc2626' }};margin:0;line-height:1;">
                        {{ number_format($attempt->percentage(), 0) }}%
                    </p>
                    <p style="font-size:0.8rem;color:#6b7280;margin:4px 0 0;">Nilai</p>
                </div>
                <div>
                    <p style="font-size:2.5rem;font-weight:800;color:#111827;margin:0;line-height:1;">
                        {{ $attempt->score }}/{{ $attempt->total_questions }}
                    </p>
                    <p style="font-size:0.8rem;color:#6b7280;margin:4px 0 0;">Benar</p>
                </div>
            </div>

            @unless($pass)
            <p style="font-size:0.8rem;color:#6b7280;margin:16px 0 0;">Nilai minimum kelulusan: 70%</p>
            @endunless
        </div>

        {{-- Detail Jawaban --}}
        <h2 style="font-size:1rem;font-weight:700;color:#111827;margin:0 0 12px;">Pembahasan Jawaban</h2>

        @foreach($results as $i => $result)
        <div class="panel-card" style="margin-bottom:10px;border-left:4px solid {{ $result['is_correct'] ? '#16a34a' : '#dc2626' }};">
            <div class="panel-card-body">
                <div style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;">
                    <div style="width:22px;height:22px;border-radius:50%;flex-shrink:0;display:flex;align-items:center;justify-content:center;
                                background:{{ $result['is_correct'] ? '#dcfce7' : '#fee2e2' }};">
                        @if($result['is_correct'])
                        <svg width="12" height="12" fill="none" stroke="#16a34a" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                        @else
                        <svg width="12" height="12" fill="none" stroke="#dc2626" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        @endif
                    </div>
                    <p style="font-weight:600;color:#111827;margin:0;line-height:1.5;font-size:0.9rem;">
                        {{ $i + 1 }}. {{ $result['question']->question_text }}
                    </p>
                </div>

                <div style="display:flex;flex-direction:column;gap:6px;padding-left:32px;">
                    @foreach(['a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D'] as $key => $label)
                    @php
                        $isCorrectOption = $key === $result['question']->correct_answer;
                        $isUserAnswer    = $key === $result['user_answer'];
                        $bg = $isCorrectOption ? '#dcfce7' : ($isUserAnswer && !$result['is_correct'] ? '#fee2e2' : 'transparent');
                        $border = $isCorrectOption ? '#16a34a' : ($isUserAnswer && !$result['is_correct'] ? '#dc2626' : '#e5e7eb');
                    @endphp
                    <div style="padding:7px 12px;border-radius:6px;border:1px solid {{ $border }};background:{{ $bg }};font-size:0.85rem;color:#374151;">
                        <strong>{{ $label }}.</strong> {{ $result['question']->{'option_' . $key} }}
                        @if($isCorrectOption)
                            <span style="font-size:0.75rem;color:#16a34a;font-weight:600;margin-left:6px;">&check; Benar</span>
                        @elseif($isUserAnswer && !$result['is_correct'])
                            <span style="font-size:0.75rem;color:#dc2626;font-weight:600;margin-left:6px;">Jawabanmu</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        {{-- Actions --}}
        <div style="display:flex;gap:12px;margin-top:20px;flex-wrap:wrap;">
            <a href="{{ route('siswa.learn', $course->slug) }}" class="btn-outline">Kembali ke Materi</a>
            <a href="{{ route('siswa.quiz.show', [$course, $quiz]) }}" class="btn-register">Coba Lagi</a>
        </div>
    </div>
</x-panel-layout>
