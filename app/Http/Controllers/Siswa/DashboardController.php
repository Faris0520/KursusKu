<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $enrolledCourses = $user->enrollments()
            ->with(['course.mentor', 'course.category'])
            ->latest('enrolled_at')
            ->get();

        $recentTransactions = $user->transactions()
            ->with('course')
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact('enrolledCourses', 'recentTransactions'));
    }
}