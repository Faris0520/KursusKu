<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> / Review
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Review - {{ $course->title }}</h1>

    <div class="panel-card">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td style="font-weight:600;">{{ $review->user->name }}</td>
                    <td style="color:#f59e0b;">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                    <td style="color:#374151;">{{ $review->comment ?? '-' }}</td>
                    <td style="color:#9ca3af;">{{ $review->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="panel-empty">Belum ada review untuk kursus ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-panel-layout>