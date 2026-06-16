<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Mentor;
use App\Http\Controllers\Siswa;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\TransactionController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isMentor()) {
        return $user->isVerified()
            ? redirect()->route('mentor.dashboard')
            : redirect()->route('mentor.pending');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/payment/{course:slug}/success', function (\App\Models\Course $course) {
        return redirect()->route('siswa.dashboard')
            ->with('success', 'Pembayaran berhasil! Kamu sekarang bisa mengakses kursus "' . $course->title . '".');
    })->name('payment.success');

    Route::get('/payment/{course:slug}/failed', function (\App\Models\Course $course) {
        return redirect()->route('courses.show', $course->slug)
            ->with('error', 'Pembayaran dibatalkan. Silakan coba lagi jika ingin melanjutkan pembelian.');
    })->name('payment.failed');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/courses/{course}/enroll-free', [EnrollmentController::class, 'enrollFree'])->name('enrollment.free');
    Route::get('/courses/{course}/pay', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/courses/{course}/pay/initiate', [TransactionController::class, 'initiate'])->name('transaction.initiate');
    Route::get('/transactions', [TransactionController::class, 'history'])->name('transactions.history');
    Route::post('/transactions/{transaction}/resume', [TransactionController::class, 'resume'])->name('transaction.resume');
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

    // Transactions
    Route::get('/transactions', [Admin\TransactionController::class, 'index'])->name('transactions.index');
});

// Mentor routes
Route::middleware(['auth', 'role:mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/pending', function () {
        return view('mentor.pending');
    })->name('pending');
});

Route::middleware(['auth', 'role:mentor', 'verified_mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [Mentor\DashboardController::class, 'index'])->name('dashboard');

    // Courses
    Route::resource('/courses', Mentor\CourseController::class)->except('show');
    Route::get('/courses/{course}', [Mentor\CourseController::class, 'show'])->name('courses.show');
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

// Midtrans callback (no auth, no CSRF)
Route::post('/api/midtrans/callback', [TransactionController::class, 'callback'])->name('midtrans.callback');