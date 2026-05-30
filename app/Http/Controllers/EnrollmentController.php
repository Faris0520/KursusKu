<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enrollFree(Course $course)
    {
        $user = auth() -> user();

        if ($user -> isEnrolled($course)) {
            return back() -> with('error', 'Kamu sudah terdaftar di kursus ini.');
        }

        if (!$course->isFree()) {
            return back()->with('error', 'Kursus ini berbayar.');
        }

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now(),
        ]);

        return redirect() -> route('siswa.learn', $course) -> with('success', 'Berhasil mendaftar kursus!');
    }
}
