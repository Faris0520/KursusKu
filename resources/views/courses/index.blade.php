<x-app-layout>
<div style="max-width:1200px;margin:0 auto;padding:40px 24px;">

    {{-- Header --}}
    <h1 style="font-size:1.375rem;font-weight:700;color:#111827;margin-bottom:10px;">Jelajahi Kursus</h1>
    <p style="font-size:0.875rem;color:#6b7280;margin-bottom:32px;">Temukan kursus yang sesuai dengan minatmu</p>

    {{-- Layout: sidebar + content --}}
    <div style="display:flex;gap:28px;align-items:flex-start;">

        {{-- Sidebar Filter --}}
        <aside style="width:220px;flex-shrink:0;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:20px;position:sticky;top:80px;">
            <form method="GET" action="{{ route('courses.index') }}" id="filter-form">
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                <div style="margin-bottom:20px;">
                    <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">Kategori</p>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#374151;cursor:pointer;">
                            <input type="radio" name="category" value=""
                                   {{ !request('category') ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:#2563eb;">
                            Semua Kategori
                        </label>
                        @foreach($categories as $cat)
                        <label style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#374151;cursor:pointer;">
                            <input type="radio" name="category" value="{{ $cat->id }}"
                                   {{ request('category') == $cat->id ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:#2563eb;">
                            {{ $cat->name }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p style="font-size:0.75rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.05em;margin-bottom:10px;">Harga</p>
                    <div style="display:flex;flex-direction:column;gap:6px;">
                        <label style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#374151;cursor:pointer;">
                            <input type="radio" name="price" value=""
                                   {{ !request('price') ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:#2563eb;">
                            Semua Harga
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#374151;cursor:pointer;">
                            <input type="radio" name="price" value="free"
                                   {{ request('price') === 'free' ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:#2563eb;">
                            Gratis
                        </label>
                        <label style="display:flex;align-items:center;gap:8px;font-size:0.875rem;color:#374151;cursor:pointer;">
                            <input type="radio" name="price" value="paid"
                                   {{ request('price') === 'paid' ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:#2563eb;">
                            Berbayar
                        </label>
                    </div>
                </div>

                @if(request('category') || request('price'))
                <a href="{{ route('courses.index', request('search') ? ['search' => request('search')] : []) }}"
                   style="display:block;margin-top:20px;font-size:0.8125rem;color:#6b7280;text-decoration:underline;">
                    Reset filter
                </a>
                @endif
            </form>
        </aside>

        {{-- Konten --}}
        <div style="flex:1;min-width:0;">

            {{-- Search + sort bar --}}
            <div style="display:flex;align-items:center;justify-content:flex-end;margin-bottom:16px;gap:12px;">
                <span style="font-size:0.875rem;color:#6b7280;">{{ $courses->total() }} kursus ditemukan</span>
                <form method="GET" action="{{ route('courses.index') }}" style="display:flex;align-items:center;gap:8px;">
                    @if(request('search'))   <input type="hidden" name="search"   value="{{ request('search') }}">   @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('price'))    <input type="hidden" name="price"    value="{{ request('price') }}">    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari kursus..."
                           style="border:1px solid #e5e7eb;border-radius:8px;padding:8px 14px;font-size:0.875rem;font-family:'Inter',sans-serif;outline:none;width:240px;"
                           onfocus="this.style.borderColor='#2563eb'" onblur="this.style.borderColor='#e5e7eb'">
                    <button type="submit"
                            style="background:#2563eb;color:#fff;border:none;border-radius:8px;padding:9px 16px;font-size:0.875rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;">
                        Cari
                    </button>
                </form>
            </div>

            @if($courses->isEmpty())
                <div style="text-align:center;padding:60px 0;color:#9ca3af;font-size:0.9375rem;">
                    Tidak ada kursus yang ditemukan.
                </div>
            @else
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">
                    @foreach($courses as $course)
                        <x-course-card :course="$course"/>
                    @endforeach
                </div>
                <div style="margin-top:28px;">{{ $courses->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
</div>
</x-app-layout>
