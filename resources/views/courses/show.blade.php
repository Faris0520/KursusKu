<x-app-layout>
    <div style="max-width:1200px;margin:0 auto;padding:40px 24px;">
        @if(session('error'))
            <div class="panel-alert panel-alert-error">{{ session('error') }}</div>
        @endif

        <div class="panel-detail-grid">
            <!-- Konten Utama -->
            <div>
                @if($course->thumbnail)
                    <img src="{{ asset('storage/' . $course->thumbnail) }}"
                         alt="{{ $course->title }}"
                         style="width:100%;height:260px;object-fit:cover;border-radius:12px;margin-bottom:24px;">
                @endif

                <h1 style="font-size:1.625rem;font-weight:800;color:#111827;margin-bottom:6px;">{{ $course->title }}</h1>
                <p style="font-size:0.875rem;color:#9ca3af;margin-bottom:20px;">
                    oleh <span style="color:#6366f1;font-weight:600;">{{ $course->mentor->name }}</span>
                    &bull; {{ $course->category->name }}
                </p>

                <div style="font-size:0.9rem;color:#374151;line-height:1.7;">
                    {!! nl2br(e($course->description)) !!}
                </div>

                <!-- Materi -->
                <div class="panel-card" style="margin-top:28px;">
                    <div class="panel-card-header">
                        <span class="panel-card-title">Materi ({{ $course->lessons->count() }})</span>
                    </div>
                    @if($course->lessons->isEmpty())
                        <div class="panel-card-body">
                            <p style="font-size:0.875rem;color:#9ca3af;">Belum ada materi.</p>
                        </div>
                    @else
                        <div class="panel-card-body" style="padding:0;">
                            @foreach($course->lessons as $i => $lesson)
                            <div style="display:flex;align-items:center;gap:12px;padding:12px 20px;border-bottom:1px solid #f3f4f6;">
                                <span style="font-size:0.8125rem;color:#9ca3af;font-variant-numeric:tabular-nums;width:20px;">{{ $i + 1 }}</span>
                                <span style="font-size:0.875rem;color:#374151;">{{ $lesson->title }}</span>
                                @unless($isEnrolled)
                                    <span style="margin-left:auto;font-size:0.75rem;color:#9ca3af;">ðŸ”’</span>
                                @endunless
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Review -->
                <div class="panel-card" style="margin-top:0;">
                    <div class="panel-card-header">
                        <span class="panel-card-title">Review ({{ $course->reviews_count }})</span>
                    </div>
                    <div class="panel-card-body" style="padding:0;">
                        @if($course->reviews->isEmpty())
                            <p style="padding:16px 20px;font-size:0.875rem;color:#9ca3af;">Belum ada review.</p>
                        @else
                            @foreach($course->reviews as $review)
                            <div style="padding:14px 20px;border-bottom:1px solid #f3f4f6;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                                    <span style="font-size:0.875rem;font-weight:600;color:#111827;">{{ $review->user->name }}</span>
                                    <span style="color:#f59e0b;font-size:0.875rem;">
                                        {{ str_repeat('â˜…', $review->rating) }}{{ str_repeat('â˜†', 5 - $review->rating) }}
                                    </span>
                                </div>
                                @if($review->comment)
                                    <p style="font-size:0.875rem;color:#374151;">{{ $review->comment }}</p>
                                @endif
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="panel-detail-sidebar">
                <div class="panel-card">
                    <div class="panel-card-body">
                        <p style="font-size:1.875rem;font-weight:800;color:#111827;margin-bottom:4px;">
                            {{ $course->isFree() ? 'Gratis' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
                        </p>
                        <p style="font-size:0.8125rem;color:#9ca3af;margin-bottom:16px;">
                            {{ $course->enrollments_count }} siswa &bull;
                            Rating {{ number_format($course->reviews_avg_rating ?? 0, 1) }}/5
                        </p>

                        @guest
                            <a href="{{ route('login') }}" class="btn-register" style="display:block;text-align:center;width:100%;">
                                Login untuk Daftar
                            </a>
                        @else
                            @if($isEnrolled)
                                <a href="{{ route('siswa.learn', $course->slug) }}"
                                   style="display:block;text-align:center;width:100%;padding:10px;background:#16a34a;color:#fff;border-radius:6px;font-weight:600;font-size:0.875rem;text-decoration:none;">
                                    Lanjut Belajar
                                </a>
                            @elseif(auth()->user()->hasRole('siswa'))
                                @if($course->isFree())
                                    <form method="POST" action="{{ route('enrollment.free', $course) }}">
                                        @csrf
                                        <button class="btn-register" style="width:100%;display:block;text-align:center;">
                                            Daftar Gratis
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('transaction.create', $course) }}">
                                        @csrf
                                        <button class="btn-register" style="width:100%;display:block;text-align:center;">
                                            Beli Kursus
                                        </button>
                                    </form>
                                @endif
                            @else
                                <p style="font-size:0.8125rem;color:#9ca3af;text-align:center;">Hanya siswa yang dapat mendaftar.</p>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>