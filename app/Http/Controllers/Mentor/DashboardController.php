<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $courses = $user->courses()->withCount('enrollments')->get();

        $stats = [
            'total_courses' => $courses->count(),
            'total_students' => $courses->sum('enrollments_count'),
            'published_courses' => $courses->where('status', 'published')->count(),
            'draft_courses' => $courses->where('status', 'draft')->count(),
        ];

        return view('mentor.dashboard', compact('stats', 'courses'));
    }
}
