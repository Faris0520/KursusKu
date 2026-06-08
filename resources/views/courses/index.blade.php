<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Jelajahi Kursus</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filter -->
            <form method="GET" action="{{ route('courses.index') }}" class="bg-white p-4 rounded-lg shadow mb-8 grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kursus..."
                       class="border-gray-300 rounded-md md:col-span-2">
                <select name="category" class="border-gray-300 rounded-md">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="price" class="border-gray-300 rounded-md">
                    <option value="">Semua Harga</option>
                    <option value="free" @selected(request('price') === 'free')>Gratis</option>
                    <option value="paid" @selected(request('price') === 'paid')>Berbayar</option>
                </select>
                <div class="md:col-span-4 flex gap-2">
                    <button class="bg-indigo-600 text-white px-6 py-2 rounded-md text-sm">Filter</button>
                    <a href="{{ route('courses.index') }}" class="px-6 py-2 rounded-md text-sm border border-gray-300">Reset</a>
                </div>
            </form>

            <!-- Grid -->
            @if($courses->isEmpty())
                <p class="text-gray-500 text-center py-12">Tidak ada kursus yang ditemukan.</p>
            @else
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($courses as $course)
                    <x-course-card :course="$course"/>
                @endforeach
            </div>
            <div class="mt-8">{{ $courses->withQueryString()->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
