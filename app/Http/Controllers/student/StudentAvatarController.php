<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Avatar;

class StudentAvatarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            return redirect()->route('student.dashboard')->with('error', 'Student not found.');
        }

        $folkloreCompleted = $student->completed_folklore ?? 0;

        // Ambil semua avatar
        $avatars = Avatar::all();

        foreach ($avatars as $avatar) {
            // Cek apakah avatar sudah ada di tabel pivot
            $studentAvatar = $student->avatars()->where('avatars.id', $avatar->id)->first();

            if (!$studentAvatar) {
                // Tambahkan avatar ke pivot dengan default locked & unselected
                $student->avatars()->attach($avatar->id, [
                    'is_unlocked' => false,
                    'is_selected' => false,
                ]);
                $studentAvatar = $student->avatars()->where('avatars.id', $avatar->id)->first();
            }

            // Unlock avatar jika syarat terpenuhi
            $avatar->is_unlocked = ($folkloreCompleted >= $avatar->unlock_condition)
                || ($studentAvatar && $studentAvatar->pivot->is_unlocked);

            // Update pivot jika baru saja di-unlock
            if ($avatar->is_unlocked && !$studentAvatar->pivot->is_unlocked) {
                $student->avatars()->updateExistingPivot($avatar->id, [
                    'is_unlocked' => true,
                    'unlocked_at' => now(),
                ]);
            }

            // Tandai apakah avatar ini sedang dipilih
            $avatar->is_selected = $studentAvatar->pivot->is_selected;
        }

        return view('student.avatar.choose-avatar', compact('avatars', 'student'));
    }

    public function select($avatarId)
    {
        $student = Auth::user()->student;

        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        // Cek apakah avatar ini sudah unlocked
        $avatar = $student->avatars()
            ->where('avatars.id', $avatarId)
            ->wherePivot('is_unlocked', true)
            ->first();

        if (!$avatar) {
            return redirect()->back()->with('error', 'Avatar belum tersedia atau belum dibuka.');
        }

        // Unselect semua avatar student
        $student->avatars()->updateExistingPivot(
            $student->avatars->pluck('id')->toArray(),
            ['is_selected' => false]
        );

        // Select avatar yang dipilih
        $student->avatars()->updateExistingPivot($avatarId, [
            'is_selected' => true,
        ]);

        return redirect()->route('student.avatar.choose')->with('success', 'Avatar berhasil dipilih!');
    }
}
