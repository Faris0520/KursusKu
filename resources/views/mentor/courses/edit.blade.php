<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> /
        <a href="{{ route('mentor.courses.show', $course) }}">{{ $course->title }}</a> / Edit
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Edit Kursus</h1>

    <div class="panel-card" style="max-width:720px;">
        <div class="panel-card-body">
            <form method="POST" action="{{ route('mentor.courses.update', $course) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="panel-form-group">
                    <label class="panel-form-label" for="title">Judul Kursus</label>
                    <input class="panel-form-input" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                    @error('title')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="category_id">Kategori</label>
                    <select class="panel-form-select" id="category_id" name="category_id">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $course->category_id) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="description">Deskripsi</label>
                    <textarea class="panel-form-textarea" id="description" name="description" required>{{ old('description', $course->description) }}</textarea>
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="price">Harga</label>
                    <input class="panel-form-input" id="price" name="price" type="number" step="1000" min="0" value="{{ old('price', $course->price) }}" required>
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="status">Status</label>
                    <select class="panel-form-select" id="status" name="status">
                        <option value="draft"      @selected($course->status === 'draft')>Draft</option>
                        <option value="published"  @selected($course->status === 'published')>Published</option>
                    </select>
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="thumbnail">Thumbnail</label>
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}"
                             style="width:120px;height:76px;object-fit:cover;border-radius:6px;display:block;margin-bottom:8px;">
                    @endif
                    <input class="panel-form-file" id="thumbnail" name="thumbnail" type="file" accept="image/*">
                    <p class="panel-form-hint">Kosongkan jika tidak ingin mengubah thumbnail.</p>
                </div>

                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn-register">Update Kursus</button>
                    <a href="{{ route('mentor.courses.show', $course) }}" class="btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>