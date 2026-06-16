<x-app-layout>
    <!-- Hero -->
    <section style="background:linear-gradient(135deg,#1e40af,#2563eb,#1d4ed8);padding:52px 0;">
        <div style="max-width:1200px;margin:0 auto;padding:0 24px;text-align:center;">
            <h1 style="font-size:2.25rem;font-weight:800;color:#fff;margin-bottom:12px;">Belajar Tanpa Batas di Kursusku</h1>
            <p style="font-size:1rem;color:rgba(255,255,255,.85);margin-bottom:28px;">Temukan kursus terbaik dari mentor berpengalaman</p>
            <a href="{{ route('courses.index') }}" class="btn-hero-primary">Jelajahi Kursus</a>
        </div>
    </section>

    <!-- Kategori -->
    <section style="padding:48px 0;">
        <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <h2 style="font-size:1.375rem;font-weight:700;color:#111827;margin-bottom:20px;">Kategori</h2>
            <div class="home-category-grid">
                @foreach($categories as $category)
                <a href="{{ route('courses.index', ['category' => $category->id]) }}"
                   class="home-category-card">
                    <p style="font-size:0.875rem;font-weight:600;color:#111827;margin-bottom:2px;">{{ $category->name }}</p>
                    <p style="font-size:0.75rem;color:#9ca3af;">{{ $category->courses_count }} kursus</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Kursus Populer -->
    <section style="background:#f9fafb;padding:48px 0 56px;">
        <div style="max-width:1200px;margin:0 auto;padding:0 24px;">
            <h2 style="font-size:1.375rem;font-weight:700;color:#111827;margin-bottom:20px;">Kursus Populer</h2>
            <div class="home-courses-grid">
                @forelse($popularCourses as $course)
                    <x-course-card :course="$course"/>
                @empty
                    <div class="panel-empty" style="grid-column:1/-1;">Belum ada kursus tersedia.</div>
                @endforelse
            </div>
        </div>
    </section>
</x-app-layout>