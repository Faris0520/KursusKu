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
            'total_users' => User::count(),
            'total_courses' => Course::count(),
            'total_transactions' => Transaction::where('status', 'paid')->count(),
            'total_enrollments' => Enrollment::count(),
            'total_revenue' => Transaction::where('status', 'paid')->sum('amount'),
            'pending_mentors' => User::where('role', 'mentor')->where('is_verified', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
