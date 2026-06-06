<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Kursus Saya</h2>
            <a href="{{ route('mentor.courses.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Buat Kursus Baru</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Materi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($courses as $course)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $course->title }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full {{ $course->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($course->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $course->lessons_count }}</td>
                            <td class="px-6 py-4">{{ $course->enrollments_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2 text-sm">
                                    <a href="{{ route('mentor.courses.edit', $course) }}" class="text-indigo-600 hover:underline">Edit</a>
                                    <a href="{{ route('mentor.lessons.index', $course) }}" class="text-indigo-600 hover:underline">Materi</a>
                                    <a href="{{ route('mentor.quizzes.index', $course) }}" class="text-indigo-600 hover:underline">Quiz</a>
                                    <a href="{{ route('mentor.courses.students', $course) }}" class="text-indigo-600 hover:underline">Siswa</a>
                                    <a href="{{ route('mentor.courses.reviews', $course) }}" class="text-indigo-600 hover:underline">Review</a>
                                    @can('delete-own-course')
                                    <form method="POST" action="{{ route('mentor.courses.destroy', $course) }}" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $courses->links() }}</div>
        </div>
    </div>
</x-app-layout>