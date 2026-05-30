<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;

class LearningController extends Controller
{
    public function show(Course $course, Lesson $lesson = null)
    {
        $user = auth()->user();

        if (!$user->isEnrolled($course)) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Kamu belum terdaftar di kursus ini.');
        }

        $lessons = $course->lessons()->orderBy('order')->get();
        $currentLesson = $lesson ?? $lessons->first();

        if (!$currentLesson) {
            return back()->with('error', 'Kursus ini belum memiliki materi.');
        }

        return view('siswa.learning', compact('course', 'lessons', 'currentLesson'));
    }
}