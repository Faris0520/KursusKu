<x-app-layout>
    <!-- Hero Section -->
    <section class="bg-indigo-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Belajar Tanpa Batas di KursusKu</h1>
            <p class="text-xl mb-8">Temukan kursus terbaik dari mentor berpengalaman</p>
            <a href="{{ route('courses.index') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Jelajahi Kursus
            </a>
        </div>
    </section>

    <!-- Kategori -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Kategori</h2>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($categories as $category)
                <a href="{{ route('courses.index', ['category' => $category->id]) }}"
                   class="bg-white p-4 rounded-lg shadow text-center hover:shadow-md transition">
                    <p class="font-semibold">{{ $category->name }}</p>
                    <p class="text-sm text-gray-500">{{ $category->courses_count }} kursus</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Kursus Populer -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6">Kursus Populer</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($popularCourses as $course)
                    <x-course-card :course="$course"/>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>