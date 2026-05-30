<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show(Course $course, Quiz $quiz)
    {
        $user = auth()->user();

        if (!$user->isEnrolled($course)) {
            abort(403);
        }

        $quiz->load('questions');

        return view('siswa.quiz.show', compact('course', 'quiz'));
    }

    public function submit(Request $request, Course $course, Quiz $quiz)
    {
        $user = auth()->user();

        if (!$user->isEnrolled($course)) {
            abort(403);
        }

        $quiz->load('questions');
        $answers = $request->input('answers', []);

        $score = 0;
        $results = [];

        foreach ($quiz->questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $userAnswer === $question->correct_answer;

            if ($isCorrect) {
                $score++;
            }

            $results[] = [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
            ];
        }

        $attempt = QuizAttempt::create([
            'user_id' => $user->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'total_questions' => $quiz->questions->count(),
            'completed_at' => now(),
        ]);

        return view('siswa.quiz.result', compact('course', 'quiz', 'attempt', 'results'));
    }
}