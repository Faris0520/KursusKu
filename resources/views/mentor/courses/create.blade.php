<x-panel-layout>
    <div class="panel-breadcrumb">
        <a href="{{ route('mentor.courses.index') }}">Kursus Saya</a> / Buat Kursus Baru
    </div>

    <h1 class="panel-page-title" style="margin:8px 0 24px;">Buat Kursus Baru</h1>

    <div class="panel-card" style="max-width:720px;">
        <div class="panel-card-body">
            <form method="POST" action="{{ route('mentor.courses.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="panel-form-group">
                    <label class="panel-form-label" for="title">Judul Kursus</label>
                    <input class="panel-form-input" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="category_id">Kategori</label>
                    <select class="panel-form-select" id="category_id" name="category_id">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="description">Deskripsi</label>
                    <textarea class="panel-form-textarea" id="description" name="description" required>{{ old('description') }}</textarea>
                    @error('description')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="price">Harga (0 = gratis)</label>
                    <input class="panel-form-input" id="price" name="price" type="number" step="1000" min="0" value="{{ old('price', 0) }}" required>
                    @error('price')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div class="panel-form-group">
                    <label class="panel-form-label" for="thumbnail">Thumbnail (opsional)</label>
                    <input class="panel-form-file" id="thumbnail" name="thumbnail" type="file" accept="image/*">
                    @error('thumbnail')<p class="panel-form-error">{{ $message }}</p>@enderror
                </div>

                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn-register">Simpan Kursus</button>
                    <a href="{{ route('mentor.courses.index') }}" class="btn-outline">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-panel-layout>