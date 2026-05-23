<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Course $course)
    {
        $this->authorizeMentor($course);
        $quizzes = $course->quizzes()->withCount('questions')->get();
        return view('mentor.quizzes.index', compact('course', 'quizzes'));
    }

    public function create(Course $course)
    {
        $this->authorizeMentor($course);
        return view('mentor.quizzes.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorizeMentor($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $course->quizzes()->create($validated);

        return redirect()->route('mentor.quizzes.index', $course)->with('success', 'Quiz berhasil dibuat.');
    }

    public function edit(Course $course, Quiz $quiz)
    {
        $this->authorizeMentor($course);
        return view('mentor.quizzes.edit', compact('course', 'quiz'));
    }

    public function update(Request $request, Course $course, Quiz $quiz)
    {
        $this->authorizeMentor($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $quiz->update($validated);

        return redirect()->route('mentor.quizzes.index', $course)->with('success', 'Quiz berhasil diupdate.');
    }

    public function destroy(Course $course, Quiz $quiz)
    {
        $this->authorizeMentor($course);
        $quiz->delete();
        return back()->with('success', 'Quiz berhasil dihapus.');
    }

    private function authorizeMentor(Course $course): void
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }
    }
}