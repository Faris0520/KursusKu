<x-panel-layout>
    <div class="panel-page-header">
        <h1 class="panel-page-title">Kursus Saya</h1>
        <a href="{{ route('mentor.courses.create') }}" class="btn-register">+ Buat Kursus Baru</a>
    </div>

    <div class="panel-card">
        <table class="panel-table">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Materi</th>
                    <th>Siswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td>
                        <a href="{{ route('mentor.courses.show', $course) }}"
                           style="color:#2563eb;text-decoration:none;font-weight:600;">
                            {{ $course->title }}
                        </a>
                    </td>
                    <td>
                        <span class="badge {{ $course->status === 'published' ? 'badge-published' : 'badge-draft' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                    </td>
                    <td>{{ $course->lessons_count }}</td>
                    <td>{{ $course->enrollments_count }}</td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:8px;">
                            <a href="{{ route('mentor.courses.edit', $course) }}" class="btn-outline btn-sm">Edit</a>
                            <a href="{{ route('mentor.lessons.index', $course) }}" class="btn-outline btn-sm">Materi</a>
                            <a href="{{ route('mentor.quizzes.index', $course) }}" class="btn-outline btn-sm">Quiz</a>
                            <a href="{{ route('mentor.courses.students', $course) }}" class="btn-outline btn-sm">Siswa</a>
                            <a href="{{ route('mentor.courses.reviews', $course) }}" class="btn-outline btn-sm">Review</a>
                            @can('delete-own-course')
                            <form method="POST" action="{{ route('mentor.courses.destroy', $course) }}"
                                  onsubmit="return confirm('Yakin hapus kursus ini?')" style="margin:0">
                                @csrf @method('DELETE')
                                <button class="btn-danger btn-sm">Hapus</button>
                            </form>
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="panel-empty">Belum ada kursus.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $courses->links() }}</div>
</x-panel-layout>