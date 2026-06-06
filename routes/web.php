<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Mentor;
use App\Http\Controllers\Siswa;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [Admin\UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Mentor Verification
    Route::get('/mentors', [Admin\MentorVerificationController::class, 'index'])->name('mentors.index');
    Route::patch('/mentors/{user}/approve', [Admin\MentorVerificationController::class, 'approve'])->name('mentors.approve');
    Route::patch('/mentors/{user}/reject', [Admin\MentorVerificationController::class, 'reject'])->name('mentors.reject');

    // Categories
    Route::resource('/categories', Admin\CategoryController::class);
});

// Mentor routes
Route::middleware(['auth', 'role:mentor', 'verified_mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [Mentor\DashboardController::class, 'index'])->name('dashboard');

    // Courses
    Route::resource('/courses', Mentor\CourseController::class)->except('show');
    Route::get('/courses/{course}/students', [Mentor\CourseController::class, 'students'])->name('courses.students');
    Route::get('/courses/{course}/reviews', [Mentor\CourseController::class, 'reviews'])->name('courses.reviews');

    // Lessons
    Route::get('/courses/{course}/lessons', [Mentor\LessonController::class, 'index'])->name('lessons.index');
    Route::get('/courses/{course}/lessons/create', [Mentor\LessonController::class, 'create'])->name('lessons.create');
    Route::post('/courses/{course}/lessons', [Mentor\LessonController::class, 'store'])->name('lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [Mentor\LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [Mentor\LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [Mentor\LessonController::class, 'destroy'])->name('lessons.destroy');

    // Quizzes
    Route::get('/courses/{course}/quizzes', [Mentor\QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/courses/{course}/quizzes/create', [Mentor\QuizController::class, 'create'])->name('quizzes.create');
    Route::post('/courses/{course}/quizzes', [Mentor\QuizController::class, 'store'])->name('quizzes.store');
    Route::get('/courses/{course}/quizzes/{quiz}/edit', [Mentor\QuizController::class, 'edit'])->name('quizzes.edit');
    Route::put('/courses/{course}/quizzes/{quiz}', [Mentor\QuizController::class, 'update'])->name('quizzes.update');
    Route::delete('/courses/{course}/quizzes/{quiz}', [Mentor\QuizController::class, 'destroy'])->name('quizzes.destroy');

    // Questions
    Route::get('/courses/{course}/quizzes/{quiz}/questions', [Mentor\QuestionController::class, 'index'])->name('questions.index');
    Route::get('/courses/{course}/quizzes/{quiz}/questions/create', [Mentor\QuestionController::class, 'create'])->name('questions.create');
    Route::post('/courses/{course}/quizzes/{quiz}/questions', [Mentor\QuestionController::class, 'store'])->name('questions.store');
    Route::get('/courses/{course}/quizzes/{quiz}/questions/{question}/edit', [Mentor\QuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/courses/{course}/quizzes/{quiz}/questions/{question}', [Mentor\QuestionController::class, 'update'])->name('questions.update');
    Route::delete('/courses/{course}/quizzes/{quiz}/questions/{question}', [Mentor\QuestionController::class, 'destroy'])->name('questions.destroy');
});

// Siswa routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [Siswa\DashboardController::class, 'index'])->name('dashboard');

    // Learning
    Route::get('/courses/{course:slug}/learn/{lesson?}', [Siswa\LearningController::class, 'show'])->name('learn');

    // Quiz
    Route::get('/courses/{course}/quizzes/{quiz}', [Siswa\QuizController::class, 'show'])->name('quiz.show');
    Route::post('/courses/{course}/quizzes/{quiz}', [Siswa\QuizController::class, 'submit'])->name('quiz.submit');

    // Review
    Route::post('/courses/{course}/review', [Siswa\ReviewController::class, 'store'])->name('review.store');
});