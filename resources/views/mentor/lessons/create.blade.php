<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> /
        <a href="{{ route('mentor.lessons.index', $course) }}">Materi</a> / Tambah
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Tambah Materi</h1>

    <div class="panel-card" style="max-width:680px;">
        <div class="panel-card-body">
            <form method="POST" action="{{ route('mentor.lessons.store', $course) }}" enctype="multipart/form-data">
                @csrf

                <div class="panel-form-group">
                    <label class="panel-form-label" for="title">Judul Materi</label>
                    <input class="panel-form-input" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="youtube_url">YouTube URL</label>
                    <input class="panel-form-input" id="youtube_url" name="youtube_url" type="url"
                           value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=..." required>
                    @error('youtube_url')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="pdf">PDF Modul (opsional, max 10MB)</label>
                    <input class="panel-form-file" id="pdf" name="pdf" type="file" accept=".pdf">
                    @error('pdf')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="order">Urutan</label>
                    <input class="panel-form-input" id="order" name="order" type="number" min="0" value="{{ old('order', 0) }}" required>
                    @error('order')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn-register">Simpan Materi</button>
                    <a href="{{ route('mentor.lessons.index', $course) }}" class="btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>