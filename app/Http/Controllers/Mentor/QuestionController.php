<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Course $course, Quiz $quiz)
    {
        $this->authorizeMentor($course);
        $questions = $quiz->questions;
        return view('mentor.questions.index', compact('course', 'quiz', 'questions'));
    }

    public function create(Course $course, Quiz $quiz)
    {
        $this->authorizeMentor($course);
        return view('mentor.questions.create', compact('course', 'quiz'));
    }

    public function store(Request $request, Course $course, Quiz $quiz)
    {
        $this->authorizeMentor($course);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        $quiz->questions()->create($validated);

        return redirect()->route('mentor.questions.index', [$course, $quiz])->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Course $course, Quiz $quiz, Question $question)
    {
        $this->authorizeMentor($course);
        return view('mentor.questions.edit', compact('course', 'quiz', 'question'));
    }

    public function update(Request $request, Course $course, Quiz $quiz, Question $question)
    {
        $this->authorizeMentor($course);

        $validated = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_answer' => 'required|in:a,b,c,d',
        ]);

        $question->update($validated);

        return redirect()->route('mentor.questions.index', [$course, $quiz])->with('success', 'Soal berhasil diupdate.');
    }

    public function destroy(Course $course, Quiz $quiz, Question $question)
    {
        $this->authorizeMentor($course);
        $question->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    private function authorizeMentor(Course $course): void
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }
    }
}