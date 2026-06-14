<x-panel-layout>
    <div class="panel-page-header">
        <h1 class="panel-page-title">Dashboard Mentor</h1>
        @can('create-course')
        <a href="{{ route('mentor.courses.create') }}" class="btn-register">+ Buat Kursus</a>
        @endcan
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <p class="stat-card-label">Total Kursus</p>
            <p class="stat-card-value">{{ $stats['total_courses'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Published</p>
            <p class="stat-card-value green">{{ $stats['published_courses'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Draft</p>
            <p class="stat-card-value yellow">{{ $stats['draft_courses'] }}</p>
        </div>
        <div class="stat-card">
            <p class="stat-card-label">Total Siswa</p>
            <p class="stat-card-value blue">{{ $stats['total_students'] }}</p>
        </div>
    </div>

    <div class="panel-card">
        <div class="panel-card-header">
            <span class="panel-card-title">Kursus Saya</span>
        </div>
        <div class="panel-card-body">
            @if($courses->isEmpty())
                <div class="panel-empty">Belum ada kursus. Klik "Buat Kursus" untuk memulai.</div>
            @else
                <div class="mentor-course-grid">
                    @foreach($courses as $course)
                    <a href="{{ route('mentor.courses.show', $course) }}" class="mentor-course-card">
                        <h4>{{ $course->title }}</h4>
                        <p class="meta">{{ $course->enrollments_count }} siswa</p>
                        <div class="mentor-course-card-footer">
                            <span class="badge {{ $course->status === 'published' ? 'badge-published' : 'badge-draft' }}">
                                {{ ucfirst($course->status) }}
                            </span>
                            <span style="font-size:0.8125rem;color:#2563eb;">Lihat &rarr;</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-panel-layout>