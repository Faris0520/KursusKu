<x-panel-layout>
    <div class="panel-page-header">
        <h1 class="panel-page-title">Dashboard Siswa</h1>
        <a href="{{ route('courses.index') }}" class="btn-register">Cari Kursus</a>
    </div>

    <div class="panel-card">
        <div class="panel-card-header">
            <span class="panel-card-title">Kursus yang Diikuti ({{ $enrolledCourses->count() }})</span>
        </div>
        <div class="panel-card-body">
            @if($enrolledCourses->isEmpty())
                <div class="panel-empty">Kamu belum mengikuti kursus apapun.
                    <a href="{{ route('courses.index') }}" style="color:#2563eb;">Cari kursus sekarang</a>
                </div>
            @else
                @foreach($enrolledCourses as $enrollment)
                <a href="{{ route('siswa.learn', $enrollment->course->slug) }}" class="enrolled-course-card">
                    @if($enrollment->course->thumbnail)
                        <img src="{{ asset('storage/' . $enrollment->course->thumbnail) }}"
                             class="enrolled-course-thumb" alt="{{ $enrollment->course->title }}">
                    @else
                        <div class="enrolled-course-thumb"
                             style="display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:1.25rem;">
                            ðŸ“š
                        </div>
                    @endif
                    <div class="enrolled-course-info">
                        <p class="enrolled-course-title">{{ $enrollment->course->title }}</p>
                        <p class="enrolled-course-meta">
                            oleh {{ $enrollment->course->mentor->name }} &bull;
                            {{ $enrollment->course->category->name }}
                        </p>
                    </div>
                    <span style="font-size:0.8125rem;color:#2563eb;flex-shrink:0;">Lanjut &rarr;</span>
                </a>
                @endforeach
            @endif
        </div>
    </div>

    <div class="panel-card">
        <div class="panel-card-header">
            <span class="panel-card-title">Transaksi Terbaru</span>
            <a href="{{ route('transactions.history') }}" style="font-size:0.8125rem;color:#2563eb;text-decoration:none;">Lihat semua</a>
        </div>
        <div class="panel-card-body" style="padding:0;">
            @if($recentTransactions->isEmpty())
                <p style="padding:16px 20px;font-size:0.875rem;color:#9ca3af;">Belum ada transaksi.</p>
            @else
                @foreach($recentTransactions as $trx)
                <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid #f3f4f6;">
                    <div>
                        <p style="font-size:0.875rem;font-weight:600;color:#111827;">{{ $trx->course->title }}</p>
                        <p style="font-size:0.8125rem;color:#9ca3af;">{{ $trx->created_at->format('d M Y') }}</p>
                    </div>
                    <div style="text-align:right;">
                        <p style="font-size:0.875rem;font-weight:600;color:#111827;">
                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                        </p>
                        @php
                            $badgeMap = ['paid'=>'badge-paid','pending'=>'badge-pending','failed'=>'badge-failed','expired'=>'badge-expired'];
                        @endphp
                        <span class="badge {{ $badgeMap[$trx->status] ?? '' }}">{{ ucfirst($trx->status) }}</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</x-panel-layout>