<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Buat Kursus Baru</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('mentor.courses.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="title" value="Judul Kursus"/>
                        <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title')" required/>
                        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="category_id" value="Kategori"/>
                        <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"@selected(old('category_id')==$cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="description" value="Deskripsi"/>
                        <textarea id="description" name="description" rows="5" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="price" value="Harga (0 = gratis)"/>
                        <x-text-input id="price" name="price" type="number" step="1000" min="0" class="mt-1 block w-full" :value="old('price', 0)" required/>
                        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="thumbnail" value="Thumbnail (opsional)"/>
                        <input id="thumbnail" name="thumbnail" type="file" accept="image/*" class="mt-1 block w-full">
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2"/>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>