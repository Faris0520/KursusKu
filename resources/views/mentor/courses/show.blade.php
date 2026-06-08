<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Detail Kursus</h2>
            <a href="{{ route('mentor.dashboard') }}" class="text-sm text-indigo-600 hover:underline">&larr; Kembali</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-64 object-cover rounded-lg mb-6">
                    @endif

                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
                        <span class="text-xs px-2 py-1 rounded-full {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                    </div>
                    <p class="text-gray-500 mt-2">{{ $course->category->name ?? '-' }}</p>

                    <div class="mt-6 prose max-w-none">
                        {!! nl2br(e($course->description)) !!}
                    </div>

                    <!-- List Materi -->
                    <div class="mt-8">
                        <h2 class="text-xl font-bold mb-4">Materi ({{ $course->lessons_count }})</h2>
                        @if($course->lessons->isEmpty())
                            <p class="text-gray-400 text-sm">Belum ada materi.</p>
                        @else
                        <div class="space-y-2">
                            @foreach($course->lessons as $i => $lesson)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded">
                                <span class="text-gray-400 font-mono text-sm">{{ $i + 1 }}</span>
                                <span>{{ $lesson->title }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <!-- Reviews -->
                    <div class="mt-8">
                        <h2 class="text-xl font-bold mb-4">Review ({{ $course->reviews_count }})</h2>
                        @if($course->reviews->isEmpty())
                            <p class="text-gray-400 text-sm">Belum ada review.</p>
                        @else
                        @foreach($course->reviews as $review)
                        <div class="border-b py-4">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold">{{ $review->user->name }}</span>
                                <span class="text-yellow-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span>
                            </div>
                            @if($review->comment)
                                <p class="text-gray-600 mt-1">{{ $review->comment }}</p>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow sticky top-6">
                        <p class="text-3xl font-bold mb-4">
                            {{ $course->isFree() ? 'Gratis' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
                        </p>

                        <div class="grid grid-cols-2 gap-3 text-center mb-6">
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-2xl font-bold">{{ $course->enrollments_count }}</p>
                                <p class="text-xs text-gray-500">Siswa</p>
                            </div>
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-2xl font-bold">{{ $course->lessons_count }}</p>
                                <p class="text-xs text-gray-500">Materi</p>
                            </div>
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-2xl font-bold">{{ $course->quizzes_count }}</p>
                                <p class="text-xs text-gray-500">Quiz</p>
                            </div>
                            <div class="bg-gray-50 rounded p-3">
                                <p class="text-2xl font-bold">{{ number_format($course->reviews_avg_rating ?? 0, 1) }}</p>
                                <p class="text-xs text-gray-500">Rating</p>
                            </div>
                        </div>

                        <div class="space-y-2 text-sm">
                            <a href="{{ route('mentor.courses.edit', $course) }}" class="block w-full text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700">Edit Kursus</a>
                            <a href="{{ route('mentor.lessons.index', $course) }}" class="block w-full text-center bg-white border border-gray-300 py-2 rounded-lg hover:bg-gray-50">Kelola Materi</a>
                            <a href="{{ route('mentor.quizzes.index', $course) }}" class="block w-full text-center bg-white border border-gray-300 py-2 rounded-lg hover:bg-gray-50">Kelola Quiz</a>
                            <a href="{{ route('mentor.courses.students', $course) }}" class="block w-full text-center bg-white border border-gray-300 py-2 rounded-lg hover:bg-gray-50">Lihat Siswa</a>
                            <a href="{{ route('mentor.courses.reviews', $course) }}" class="block w-full text-center bg-white border border-gray-300 py-2 rounded-lg hover:bg-gray-50">Lihat Review</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
