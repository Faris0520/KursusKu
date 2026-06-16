<x-panel-layout>

<div class="panel-page-header">
    <div>
        <p class="panel-breadcrumb"><a href="{{ route('admin.dashboard') }}">Dashboard</a> / Kategori</p>
        <h1 class="panel-page-title">Kelola Kategori</h1>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="btn-register" style="font-size:0.875rem;padding:8px 18px;text-decoration:none;">
        + Tambah Kategori
    </a>
</div>

<div class="panel-card">
    <div class="panel-card-header">
        <span class="panel-card-title">Daftar Kategori</span>
        <span style="font-size:0.8125rem;color:#9ca3af;">{{ $categories->total() }} kategori</span>
    </div>
    <table class="panel-table">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th>Slug</th>
                <th>Jumlah Kursus</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
            <tr>
                <td style="font-weight:500;color:#111827;">{{ $category->name }}</td>
                <td style="color:#9ca3af;font-size:0.8125rem;font-family:monospace;">{{ $category->slug }}</td>
                <td>
                    <span style="background:#eff6ff;color:#2563eb;font-size:0.75rem;font-weight:600;padding:3px 10px;border-radius:999px;">
                        {{ $category->courses_count }} kursus
                    </span>
                </td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn-outline btn-sm">Edit</a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori &quot;{{ addslashes($category->name) }}&quot;?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="panel-empty">Belum ada kategori. <a href="{{ route('admin.categories.create') }}" style="color:#2563eb;">Tambah sekarang →</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($categories->hasPages())
    <div style="padding:16px 20px;border-top:1px solid #f3f4f6;">
        {{ $categories->links() }}
    </div>
    @endif
</div>

</x-panel-layout>
