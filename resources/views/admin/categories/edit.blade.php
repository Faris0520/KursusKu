<x-panel-layout>

<div class="panel-page-header">
    <div>
        <p class="panel-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.categories.index') }}">Kategori</a> /
            Edit
        </p>
        <h1 class="panel-page-title">Edit Kategori</h1>
    </div>
</div>

<div class="panel-card" style="max-width:520px;">
    <div class="panel-card-header">
        <span class="panel-card-title">Edit: {{ $category->name }}</span>
    </div>
    <div class="panel-card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf @method('PUT')
            <div class="panel-form-group">
                <label class="panel-form-label" for="name">Nama Kategori</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    class="panel-form-input @error('name') is-invalid @enderror"
                    autofocus
                >
                @error('name')
                    <p class="panel-form-error">{{ $message }}</p>
                @enderror
                <p class="panel-form-hint">Slug saat ini: <code>{{ $category->slug }}</code></p>
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn-register" style="font-size:0.875rem;padding:9px 22px;">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-outline" style="font-size:0.875rem;padding:9px 22px;text-decoration:none;">Batal</a>
            </div>
        </form>
    </div>
</div>

</x-panel-layout>
