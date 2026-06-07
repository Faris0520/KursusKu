<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::where('status', 'published')
            ->with(['mentor', 'category'])
            ->withCount('enrollments', 'reviews')
            ->withAvg('reviews', 'rating')
            ->when($request->search, fn($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($request->category, fn($q, $cat) => $q->where('category_id', $cat))
            ->when($request->price === 'free', fn($q) => $q->where('price', 0))
            ->when($request->price === 'paid', fn($q) => $q->where('price', '>', 0))
            ->latest()
            ->paginate(12);

        $categories = Category::all();

        return view('courses.index', compact('courses', 'categories'));
    }

    public function show(Course $course)
    {
        $course->load(['mentor', 'category', 'lessons', 'reviews.user']);
        $course->loadCount('enrollments', 'reviews');
        $course->loadAvg('reviews', 'rating');

        $isEnrolled = auth()->check() ? auth()->user()->isEnrolled($course) : false;

        return view('courses.show', compact('course', 'isEnrolled'));
    }
}
