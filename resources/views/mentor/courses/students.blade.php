<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> / Siswa
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Siswa - {{ $course->title }}</h1>

    <div class="panel-card">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Terdaftar Sejak</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                <tr>
                    <td style="font-weight:600;">{{ $enrollment->user->name }}</td>
                    <td style="color:#6b7280;">{{ $enrollment->user->email }}</td>
                    <td style="color:#9ca3af;">{{ $enrollment->enrolled_at?->format('d M Y') ?? $enrollment->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="panel-empty">Belum ada siswa yang mendaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-panel-layout>