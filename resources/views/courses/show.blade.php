<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    @if($course->thumbnail)
                        <div class="w-full aspect-video rounded-lg overflow-hidden mb-6">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <h1 class="text-3xl font-bold">{{ $course->title }}</h1>
                    <p class="text-gray-500 mt-2">oleh {{ $course->mentor->name }} &bull; {{ $course->category->name }}</p>

                    <div class="mt-6 prose max-w-none">
                        {!! nl2br(e($course->description)) !!}
                    </div>

                    <!-- List Materi -->
                    <div class="mt-8">
                        <h2 class="text-xl font-bold mb-4">Materi ({{ $course->lessons->count() }})</h2>
                        @if($course->lessons->isEmpty())
                            <p class="text-gray-400 text-sm">Belum ada materi.</p>
                        @else
                        <div class="space-y-2">
                            @foreach($course->lessons as $i => $lesson)
                            <div class="flex items-center gap-3 p-3 bg-gray-50 rounded">
                                <span class="text-gray-400 font-mono text-sm">{{ $i + 1 }}</span>
                                <span>{{ $lesson->title }}</span>
                                @unless($isEnrolled)
                                    <span class="ml-auto text-xs text-gray-400">🔒</span>
                                @endunless
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
                        <p class="text-sm text-gray-500 mb-2">{{ $course->enrollments_count }} siswa terdaftar</p>
                        <p class="text-sm text-gray-500 mb-4">Rating: {{ number_format($course->reviews_avg_rating ?? 0, 1) }}/5</p>

                        @guest
                            <a href="{{ route('login') }}" class="block w-full text-center bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                                Login untuk Daftar
                            </a>
                        @else
                            @if($isEnrolled)
                                <a href="{{ route('siswa.learn', $course->slug) }}" class="block w-full text-center bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700">
                                    Lanjut Belajar
                                </a>
                            @elseif(auth()->user()->isSiswa())
                                @if($course->isFree())
                                    <form method="POST" action="{{ route('enrollment.free', $course) }}">
                                        @csrf
                                        <button class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                                            Daftar Gratis
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('transaction.create', $course) }}"
                                       class="block w-full text-center bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700">
                                        Beli Kursus
                                    </a>
                                @endif
                            @else
                                <p class="text-sm text-gray-500 text-center">Hanya siswa yang dapat mendaftar kursus.</p>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
