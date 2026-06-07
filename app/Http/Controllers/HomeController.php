<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $popularCourses = Course::where('status', 'published')
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(8)
            ->get();

        $categories = Category::withCount('courses')->get();

        return view('home', compact('popularCourses', 'categories'));
    }
}
