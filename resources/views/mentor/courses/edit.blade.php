<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Kursus: {{ $course->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('mentor.courses.update', $course) }}" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-4">
                        <x-input-label for="title" value="Judul Kursus"/>
                        <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title', $course->title)" required/>
                        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="category_id" value="Kategori"/>
                        <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"@selected(old('category_id',$course->category_id) == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="description" value="Deskripsi"/>
                        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description', $course->description) }}</textarea>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="price" value="Harga"/>
                        <x-text-input id="price" name="price" type="number" step="1000" min="0" class="mt-1 block w-full" :value="old('price', $course->price)" required/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="status" value="Status"/>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="draft"@selected($course->status == 'draft')>Draft</option>
                            <option value="published"@selected($course->status == 'published')>Published</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="thumbnail" value="Thumbnail (kosongkan jika tidak diubah)"/>
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-32 h-20 object-cover rounded mb-2">
                        @endif
                        <input id="thumbnail" name="thumbnail" type="file" accept="image/*" class="mt-1 block w-full">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Update</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>