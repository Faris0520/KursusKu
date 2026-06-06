<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $user = auth()->user();

        if (!$user->isEnrolled($course)) {
            return back()->with('error', 'Kamu harus terdaftar di kursus ini untuk memberi review.');
        }

        $existing = Review::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if ($existing) {
            return back()->with('error', 'Kamu sudah pernah memberi review untuk kursus ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }
}