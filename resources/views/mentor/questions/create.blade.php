<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Soal: {{ $quiz->title }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <form method="POST" action="{{ route('mentor.questions.store', [$course, $quiz]) }}">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="question_text" value="Pertanyaan"/>
                        <textarea id="question_text" name="question_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('question_text') }}</textarea>
                        <x-input-error :messages="$errors->get('question_text')" class="mt-2"/>
                    </div>
                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                    <div class="mb-4">
                        <x-input-label for="option_{{ $opt }}" value="Opsi {{ strtoupper($opt) }}"/>
                        <x-text-input id="option_{{ $opt }}" name="option_{{ $opt }}" class="mt-1 block w-full" :value="old('option_'.$opt)" required/>
                        <x-input-error :messages="$errors->get('option_'.$opt)" class="mt-2"/>
                    </div>
                    @endforeach
                    <div class="mb-4">
                        <x-input-label for="correct_answer" value="Jawaban Benar"/>
                        <select id="correct_answer" name="correct_answer" class="mt-1 block w-full rounded-md border-gray-300" required>
                            <option value="a">A</option>
                            <option value="b">B</option>
                            <option value="c">C</option>
                            <option value="d">D</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700">Simpan Soal</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>