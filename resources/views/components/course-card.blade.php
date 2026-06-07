@props(['course'])

<a href="{{ route('courses.show', $course->slug) }}" class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition block">
    @if($course->thumbnail)
        <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-40 object-cover">
    @else
        <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
            <span class="text-gray-400">No Image</span>
        </div>
    @endif
    <div class="p-4">
        <p class="text-xs text-indigo-600 font-medium">{{ $course->category->name ?? '' }}</p>
        <h3 class="font-semibold mt-1 line-clamp-2">{{ $course->title }}</h3>
        <p class="text-sm text-gray-500 mt-1">{{ $course->mentor->name ?? '' }}</p>
        <div class="flex items-center justify-between mt-3">
            <span class="font-bold {{ $course->isFree() ? 'text-green-600' : 'text-gray-900' }}">
                {{ $course->isFree() ? 'Gratis' : 'Rp ' . number_format($course->price, 0, ',', '.') }}
            </span>
            <span class="text-xs text-gray-500">{{ $course->enrollments_count ?? 0 }} siswa</span>
        </div>
    </div>
</a>