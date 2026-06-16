<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Transaction;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'        => User::count(),
            'total_siswa'        => User::where('role', 'siswa')->count(),
            'total_mentors'      => User::where('role', 'mentor')->count(),
            'total_courses'      => Course::count(),
            'published_courses'  => Course::where('status', 'published')->count(),
            'total_enrollments'  => Enrollment::count(),
            'total_revenue'      => Transaction::where('status', 'paid')->sum('amount'),
            'pending_mentors'    => User::where('role', 'mentor')->where('is_verified', false)->count(),
        ];

        $recentTransactions = Transaction::with(['user', 'course'])
            ->where('status', 'paid')
            ->latest('paid_at')
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        $topCourses = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'recentUsers', 'topCourses'));
    }
}
