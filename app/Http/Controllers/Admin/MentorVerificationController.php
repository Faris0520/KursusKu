<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class MentorVerificationController extends Controller
{
    public function index()
    {
        $pendingMentors = User::where('role', 'mentor')
            ->where('is_verified', false)
            ->latest()
            ->paginate(15);

        return view('admin.mentors.index', compact('pendingMentors'));
    }

    public function approve(User $user)
    {
        $this->authorize('verify-mentor'); // Spatie

        $user->update(['is_verified' => true]);
        return back()->with('success', "Mentor{$user->name} berhasil diverifikasi.");
    }

    public function reject(User $user)
    {
        $this->authorize('verify-mentor'); // Spatie

        $user->update(['role' => 'siswa', 'is_verified' => false]);
        $user->syncRoles(['siswa']); // Sinkron dengan Spatie Permission
        return back()->with('success', "Mentor{$user->name} ditolak dan dikembalikan ke siswa.");
    }
}