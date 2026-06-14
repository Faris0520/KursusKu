<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> /
        <a href="{{ route('mentor.lessons.index', $course) }}">Materi</a> / Edit
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Edit Materi</h1>

    <div class="panel-card" style="max-width:680px;">
        <div class="panel-card-body">
            <form method="POST" action="{{ route('mentor.lessons.update', [$course, $lesson]) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="panel-form-group">
                    <label class="panel-form-label" for="title">Judul Materi</label>
                    <input class="panel-form-input" id="title" name="title" value="{{ old('title', $lesson->title) }}" required>
                    @error('title')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="youtube_url">YouTube URL</label>
                    <input class="panel-form-input" id="youtube_url" name="youtube_url" type="url"
                           value="{{ old('youtube_url', $lesson->youtube_url) }}" required>
                    @error('youtube_url')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="pdf">PDF Modul (opsional)</label>
                    <input class="panel-form-file" id="pdf" name="pdf" type="file" accept=".pdf">
                    <p class="panel-form-hint">Kosongkan jika tidak ingin mengubah PDF.</p>
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="order">Urutan</label>
                    <input class="panel-form-input" id="order" name="order" type="number" min="0" value="{{ old('order', $lesson->order) }}" required>
                </div>

                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn-register">Update Materi</button>
                    <a href="{{ route('mentor.lessons.index', $course) }}" class="btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>