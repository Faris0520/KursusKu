<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Materi: {{ $course->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('mentor.lessons.store', $course) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="title" value="Judul Materi"/>
                        <x-text-input id="title" name="title" class="mt-1 block w-full" :value="old('title')" required/>
                        <x-input-error :messages="$errors->get('title')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="youtube_url" value="YouTube URL"/>
                        <x-text-input id="youtube_url" name="youtube_url" type="url" class="mt-1 block w-full" :value="old('youtube_url')" placeholder="https://www.youtube.com/watch?v=..." required/>
                        <x-input-error :messages="$errors->get('youtube_url')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="pdf" value="PDF Modul (opsional, max 10MB)"/>
                        <input id="pdf" name="pdf" type="file" accept=".pdf" class="mt-1 block w-full">
                        <x-input-error :messages="$errors->get('pdf')" class="mt-2"/>
                    </div>
                    <div class="mb-4">
                        <x-input-label for="order" value="Urutan"/>
                        <x-text-input id="order" name="order" type="number" min="0" class="mt-1 block w-full" :value="old('order', 0)" required/>
                        <x-input-error :messages="$errors->get('order')" class="mt-2"/>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>