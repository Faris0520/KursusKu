<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('siswa.dashboard') }}">Dashboard</a> /
        <a href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a> /
        {{ $currentLesson->title }}
    </div>

    <div class="learning-layout" style="margin-top:16px;">

        {{-- Lesson Sidebar --}}
        <div class="learning-sidebar">
            <div class="panel-card">
                <div class="panel-card-header">
                    <span class="panel-card-title">Materi ({{ $lessons->count() }})</span>
                </div>
                <div style="padding:0;">
                    @foreach($lessons as $lesson)
                    <a href="{{ route('siswa.learn', ['course' => $course->slug, 'lesson' => $lesson->id]) }}"
                       class="learning-lesson-item {{ $lesson->id === $currentLesson->id ? 'active' : '' }}">
                        <span class="learning-lesson-num">{{ $lesson->order }}</span>
                        <span class="learning-lesson-title">{{ $lesson->title }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            @if($course->quizzes->isNotEmpty())
            <div class="panel-card" style="margin-top:16px;">
                <div class="panel-card-header">
                    <span class="panel-card-title">Quiz</span>
                </div>
                <div style="padding:10px 14px;display:flex;flex-direction:column;gap:8px;">
                    @foreach($course->quizzes as $quiz)
                    <a href="{{ route('siswa.quiz.show', [$course, $quiz]) }}"
                       class="btn-outline btn-sm" style="text-align:center;display:block;">
                        {{ $quiz->title }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Main Content --}}
        <div class="learning-main-col">
            <h1 style="font-size:1.25rem;font-weight:700;color:#111827;margin:0 0 16px;">
                {{ $currentLesson->order }}. {{ $currentLesson->title }}
            </h1>

            {{-- YouTube Embed --}}
            @if($currentLesson->youtube_url)
                @php
                    preg_match(
                        '/(?:youtube\.com\/(?:.*[?&]v=|embed\/|v\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
                        $currentLesson->youtube_url,
                        $ytMatch
                    );
                    $videoId = $ytMatch[1] ?? null;
                @endphp

                @if($videoId)
                <div class="youtube-embed">
                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                            title="{{ $currentLesson->title }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
                @else
                <div class="panel-alert panel-alert-error" style="margin-bottom:16px;">
                    URL video tidak valid: {{ $currentLesson->youtube_url }}
                </div>
                @endif
            @endif

            {{-- PDF Download --}}
            @if($currentLesson->pdf_path)
            <div style="margin-bottom:20px;">
                <a href="{{ asset('storage/' . $currentLesson->pdf_path) }}"
                   target="_blank" rel="noopener"
                   class="btn-outline"
                   style="display:inline-flex;align-items:center;gap:8px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Download PDF Modul
                </a>
            </div>
            @endif

            {{-- Lesson Navigation --}}
            @php
                $prevLesson = $lessons->where('order', '<', $currentLesson->order)->last();
                $nextLesson = $lessons->where('order', '>', $currentLesson->order)->first();
            @endphp
            <div style="display:flex;justify-content:space-between;align-items:center;padding:16px 0;border-top:1px solid #f0f0f0;border-bottom:1px solid #f0f0f0;margin-bottom:24px;">
                @if($prevLesson)
                <a href="{{ route('siswa.learn', ['course' => $course->slug, 'lesson' => $prevLesson->id]) }}"
                   class="btn-outline" style="display:flex;align-items:center;gap:6px;max-width:45%;overflow:hidden;">
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $prevLesson->title }}</span>
                </a>
                @else
                <span></span>
                @endif

                @if($nextLesson)
                <a href="{{ route('siswa.learn', ['course' => $course->slug, 'lesson' => $nextLesson->id]) }}"
                   class="btn-register" style="display:flex;align-items:center;gap:6px;max-width:45%;overflow:hidden;">
                    <span style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $nextLesson->title }}</span>
                    <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
                @endif
            </div>

            {{-- Review Form â€” only on last lesson --}}
            @unless($nextLesson)
            <div class="panel-card">
                <div class="panel-card-header">
                    <span class="panel-card-title">Beri Ulasan Kursus</span>
                </div>
                <div class="panel-card-body">
                    @if(auth()->user()->reviews()->where('course_id', $course->id)->exists())
                        <p style="font-size:0.875rem;color:#6b7280;">
                            Kamu sudah memberikan ulasan untuk kursus ini. Terima kasih!
                        </p>
                    @else
                    <form method="POST" action="{{ route('siswa.review.store', $course) }}">
                        @csrf

                        <div class="panel-form-group" x-data="{ rating: {{ old('rating', 5) }} }">
                            <label class="panel-form-label">Rating</label>
                            <div style="display:flex;gap:6px;margin-top:6px;">
                                @for($star = 1; $star <= 5; $star++)
                                <label style="cursor:pointer;font-size:1.75rem;line-height:1;"
                                       title="{{ $star }} bintang">
                                    <input type="radio" name="rating" value="{{ $star }}"
                                           style="position:absolute;opacity:0;width:0;"
                                           @click="rating = {{ $star }}"
                                           @if(old('rating', 5) == $star) checked @endif>
                                    <span @click="rating = {{ $star }}"
                                          :style="rating >= {{ $star }} ? 'color:#f59e0b' : 'color:#d1d5db'"
                                          style="{{ old('rating', 5) >= $star ? 'color:#f59e0b' : 'color:#d1d5db' }}">â˜…</span>
                                </label>
                                @endfor
                            </div>
                            @error('rating')<p class="panel-form-error">{{ $message }}</p>@enderror
                        </div>

                        <div class="panel-form-group">
                            <label class="panel-form-label" for="comment">Komentar (opsional)</label>
                            <textarea class="panel-form-textarea" id="comment" name="comment"
                                      rows="3" placeholder="Bagikan pengalamanmu tentang kursus ini...">{{ old('comment') }}</textarea>
                        </div>

                        <button type="submit" class="btn-register">Kirim Ulasan</button>
                    </form>
                    @endif
                </div>
            </div>
            @endunless
        </div>

    </div>
</x-panel-layout>