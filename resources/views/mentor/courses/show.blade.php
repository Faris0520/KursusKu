<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> / {{ $course->title }}
    </div>

    <div class="panel-page-header" style="margin-top:8px;">
        <h1 class="panel-page-title">{{ $course->title }}</h1>
        <span class="badge {{ $course->status === 'published' ? 'badge-published' : 'badge-draft' }}">
            {{ ucfirst($course->status) }}
        </span>
    </div>

    <div class="panel-detail-grid">
        <!-- Konten -->
        <div>
            @if($course->thumbnail)
                <img src="{{ asset('storage/' . $course->thumbnail) }}"
                     alt="{{ $course->title }}"
                     style="width:100%;height:220px;object-fit:cover;border-radius:10px;margin-bottom:20px;">
            @endif

            <div class="panel-card">
                <div class="panel-card-header">
                    <span class="panel-card-title">Deskripsi</span>
                </div>
                <div class="panel-card-body" style="font-size:0.875rem;color:#374151;line-height:1.7;">
                    {!! nl2br(e($course->description)) !!}
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card-header">
                    <span class="panel-card-title">Materi ({{ $course->lessons_count }})</span>
                </div>
                <div class="panel-card-body" style="padding:0;">
                    @forelse($course->lessons as $i => $lesson)
                    <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #f3f4f6;">
                        <span style="font-size:0.8125rem;color:#9ca3af;width:20px;">{{ $i + 1 }}</span>
                        <span style="font-size:0.875rem;color:#374151;">{{ $lesson->title }}</span>
                    </div>
                    @empty
                    <p style="padding:14px 20px;font-size:0.875rem;color:#9ca3af;">Belum ada materi.</p>
                    @endforelse
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-card-header">
                    <span class="panel-card-title">Review ({{ $course->reviews_count }})</span>
                </div>
                <div class="panel-card-body" style="padding:0;">
                    @forelse($course->reviews as $review)
                    <div style="padding:14px 20px;border-bottom:1px solid #f3f4f6;">
                        <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                            <span style="font-size:0.875rem;font-weight:600;color:#111827;">{{ $review->user->name }}</span>
                            <span style="color:#f59e0b;">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                        </div>
                        @if($review->comment)
                            <p style="font-size:0.875rem;color:#374151;">{{ $review->comment }}</p>
                        @endif
                    </div>
                    @empty
                    <p style="padding:14px 20px;font-size:0.875rem;color:#9ca3af;">Belum ada review.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="panel-detail-sidebar">
            <div class="panel-card">
                <div class="panel-card-header"><span class="panel-card-title">Statistik</span></div>
                <div class="panel-card-body">
                    <div class="panel-stat-mini-grid">
                        <div class="panel-stat-mini">
                            <p class="panel-stat-mini-val">{{ $course->enrollments_count }}</p>
                            <p class="panel-stat-mini-label">Siswa</p>
                        </div>
                        <div class="panel-stat-mini">
                            <p class="panel-stat-mini-val">{{ $course->lessons_count }}</p>
                            <p class="panel-stat-mini-label">Materi</p>
                        </div>
                        <div class="panel-stat-mini">
                            <p class="panel-stat-mini-val">{{ $course->quizzes_count }}</p>
                            <p class="panel-stat-mini-label">Quiz</p>
                        </div>
                        <div class="panel-stat-mini">
                            <p class="panel-stat-mini-val">{{ number_format($course->reviews_avg_rating ?? 0, 1) }}</p>
                            <p class="panel-stat-mini-label">Rating</p>
                        </div>
                    </div>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        <a href="{{ route('mentor.courses.edit', $course) }}" class="btn-register" style="text-align:center;display:block;">Edit Kursus</a>
                        <a href="{{ route('mentor.lessons.index', $course) }}" class="btn-outline" style="text-align:center;display:block;">Kelola Materi</a>
                        <a href="{{ route('mentor.quizzes.index', $course) }}" class="btn-outline" style="text-align:center;display:block;">Kelola Quiz</a>
                        <a href="{{ route('mentor.courses.students', $course) }}" class="btn-outline" style="text-align:center;display:block;">Lihat Siswa</a>
                        <a href="{{ route('mentor.courses.reviews', $course) }}" class="btn-outline" style="text-align:center;display:block;">Lihat Review</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-panel-layout>