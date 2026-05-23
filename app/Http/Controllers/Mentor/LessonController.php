<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function index(Course $course)
    {
        $this->authorizeMentor($course);
        $lessons = $course->lessons()->orderBy('order')->get();
        return view('mentor.lessons.index', compact('course', 'lessons'));
    }

    public function create(Course $course)
    {
        $this->authorizeMentor($course);
        return view('mentor.lessons.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorizeMentor($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'order' => 'required|integer|min:0',
        ]);

        $data = [
            'course_id' => $course->id,
            'title' => $validated['title'],
            'youtube_url' => $validated['youtube_url'],
            'order' => $validated['order'],
        ];

        if ($request->hasFile('pdf')) {
            $data['pdf_path'] = $request->file('pdf')->store('pdfs', 'public');
        }

        Lesson::create($data);

        return redirect()->route('mentor.lessons.index', $course)->with('success', 'Materi berhasil ditambahkan.');
    }

    public function edit(Course $course, Lesson $lesson)
    {
        $this->authorizeMentor($course);
        return view('mentor.lessons.edit', compact('course', 'lesson'));
    }

    public function update(Request $request, Course $course, Lesson $lesson)
    {
        $this->authorizeMentor($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'youtube_url' => 'required|url',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'order' => 'required|integer|min:0',
        ]);

        $data = [
            'title' => $validated['title'],
            'youtube_url' => $validated['youtube_url'],
            'order' => $validated['order'],
        ];

        if ($request->hasFile('pdf')) {
            if ($lesson->pdf_path) {
                Storage::disk('public')->delete($lesson->pdf_path);
            }
            $data['pdf_path'] = $request->file('pdf')->store('pdfs', 'public');
        }

        $lesson->update($data);

        return redirect()->route('mentor.lessons.index', $course)->with('success', 'Materi berhasil diupdate.');
    }

    public function destroy(Course $course, Lesson $lesson)
    {
        $this->authorizeMentor($course);
        if ($lesson->pdf_path) {
            Storage::disk('public')->delete($lesson->pdf_path);
        }
        $lesson->delete();

        return back()->with('success', 'Materi berhasil dihapus.');
    }

    private function authorizeMentor(Course $course): void
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }
    }
}