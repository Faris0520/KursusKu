<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> / Materi
    </div>

    <div class="panel-page-header" style="margin-top:8px;">
        <h1 class="panel-page-title">Materi Kursus</h1>
        <a href="{{ route('mentor.lessons.create', $course) }}" class="btn-register">+ Tambah Materi</a>
    </div>

    <div>
        @forelse($lessons as $lesson)
        <div class="panel-list-item">
            <div class="panel-list-item-info">
                <p class="panel-list-item-title">{{ $lesson->order }}. {{ $lesson->title }}</p>
                <p class="panel-list-item-meta">{{ $lesson->youtube_url }}</p>
            </div>
            <div class="panel-list-item-actions">
                <a href="{{ route('mentor.lessons.edit', [$course, $lesson]) }}" class="btn-outline btn-sm">Edit</a>
                <form method="POST" action="{{ route('mentor.lessons.destroy', [$course, $lesson]) }}"
                      onsubmit="return confirm('Yakin hapus materi ini?')" style="margin:0">
                    @csrf @method('DELETE')
                    <button class="btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <div class="panel-empty">Belum ada materi. Tambahkan materi pertama.</div>
        @endforelse
    </div>
</x-panel-layout>