<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = auth()->user()->courses()
            ->with('enrollments', 'lessons')
            ->latest()
            ->paginate(10);

        return view('mentor.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('mentor.courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create-course'); // Spatie

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $validated['mentor_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($validated);

        return redirect()->route('mentor.courses.index')->with('success', 'Kursus berhasil dibuat.');
    }

    public function show(Course $course)
    {
        $this->authorizeMentor($course);

        $course->load(['category', 'lessons', 'reviews.user']);
        $course->loadCount(['enrollments', 'lessons', 'reviews', 'quizzes']);
        $course->loadAvg('reviews', 'rating');

        return view('mentor.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorizeMentor($course);
        $categories = Category::all();
        return view('mentor.courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('edit-own-course'); // Spatie
        $this->authorizeMentor($course);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('mentor.courses.index')->with('success', 'Kursus berhasil diupdate.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete-own-course'); // Spatie
        $this->authorizeMentor($course);
        
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();

        return back()->with('success', 'Kursus berhasil dihapus.');
    }

    public function students(Course $course)
    {
        $this->authorizeMentor($course);
        $enrollments = $course->enrollments()->with('user')->latest()->paginate(20);
        return view('mentor.courses.students', compact('course', 'enrollments'));
    }

    public function reviews(Course $course)
    {
        $this->authorizeMentor($course);
        $reviews = $course->reviews()->with('user')->latest()->paginate(20);
        return view('mentor.courses.reviews', compact('course', 'reviews'));
    }

    private function authorizeMentor(Course $course): void
    {
        if ($course->mentor_id !== auth()->id()) {
            abort(403);
        }
    }
}
