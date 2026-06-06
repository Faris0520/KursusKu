<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'bio',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_verified' => 'boolean',
        ];
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isMentor(): bool
    {
        return $this->role === 'mentor';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isVerified(): bool
    {
        return $this->is_verified;
    }

    public function courses()
{
    return $this->hasMany(Course::class, 'mentor_id');
}

public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

public function enrolledCourses()
{
    return $this->belongsToMany(Course::class, 'enrollments')->withPivot('enrolled_at');
}

public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function quizAttempts()
{
    return $this->hasMany(QuizAttempt::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

public function isEnrolled(Course $course): bool
{
    return $this->enrollments()->where('course_id', $course->id)->exists();
}
}