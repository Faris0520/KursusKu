<x-panel-layout>

<div class="panel-page-header">
    <div>
        <p class="panel-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a> /
            <a href="{{ route('admin.categories.index') }}">Kategori</a> /
            Tambah
        </p>
        <h1 class="panel-page-title">Tambah Kategori</h1>
    </div>
</div>

<div class="panel-card" style="max-width:520px;">
    <div class="panel-card-header">
        <span class="panel-card-title">Form Kategori Baru</span>
    </div>
    <div class="panel-card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="panel-form-group">
                <label class="panel-form-label" for="name">Nama Kategori</label>
                <input
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="panel-form-input @error('name') is-invalid @enderror"
                    placeholder="Contoh: Pemrograman Web"
                    autofocus
                >
                @error('name')
                    <p class="panel-form-error">{{ $message }}</p>
                @enderror
            </div>

            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn-register" style="font-size:0.875rem;padding:9px 22px;">Simpan</button>
                <a href="{{ route('admin.categories.index') }}" class="btn-outline" style="font-size:0.875rem;padding:9px 22px;text-decoration:none;">Batal</a>
            </div>
        </form>
    </div>
</div>

</x-panel-layout>
