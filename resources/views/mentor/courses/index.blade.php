<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold mb-6">Semua Kursus</h1>

            <!-- Filter -->
            <form method="GET" class="mb-8 flex flex-wrap gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kursus..."
                       class="rounded-md border-gray-300 flex-1 min-w-[200px]">
                <select name="category" class="rounded-md border-gray-300">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}"@selected(request('category')==$cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <select name="price" class="rounded-md border-gray-300">
                    <option value="">Semua Harga</option>
                    <option value="free"@selected(request('price')=='free')>Gratis</option>
                    <option value="paid"@selected(request('price')=='paid')>Berbayar</option>
                </select>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md">Cari</button>
            </form>

            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @forelse($courses as $course)
                    <x-course-card :course="$course"/>
                @empty
                    <p class="col-span-4 text-center text-gray-500 py-12">Tidak ada kursus ditemukan.</p>
                @endforelse
            </div>

            <div class="mt-8">{{ $courses->links() }}</div>
        </div>
    </div>
</x-app-layout>