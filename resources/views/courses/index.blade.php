<x-app-layout>
    <div style="max-width:1200px;margin:0 auto;padding:40px 24px;">
        <h1 style="font-size:1.375rem;font-weight:700;color:#111827;margin-bottom:24px;">Jelajahi Kursus</h1>

        <form method="GET" action="{{ route('courses.index') }}" class="catalog-filter-bar">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari kursus..." class="panel-form-input" aria-label="Cari kursus">
            <select name="category" class="panel-form-select" aria-label="Filter kategori">
                <option value="">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <select name="price" class="panel-form-select" aria-label="Filter harga">
                <option value="">Semua Harga</option>
                <option value="free"  @selected(request('price') === 'free')>Gratis</option>
                <option value="paid"  @selected(request('price') === 'paid')>Berbayar</option>
            </select>
            <div style="display:flex;gap:8px;">
                <button type="submit" class="btn-register">Filter</button>
                <a href="{{ route('courses.index') }}" class="btn-outline">Reset</a>
            </div>
        </form>

        @if($courses->isEmpty())
            <div class="panel-empty">Tidak ada kursus yang ditemukan.</div>
        @else
            <div class="catalog-grid">
                @foreach($courses as $course)
                    <x-course-card :course="$course"/>
                @endforeach
            </div>
            <div style="margin-top:28px;">{{ $courses->withQueryString()->links() }}</div>
        @endif
    </div>
</x-app-layout>