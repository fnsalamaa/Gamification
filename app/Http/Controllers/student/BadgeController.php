<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Badge;
use App\Traits\ChecksBadgeUnlock;

class BadgeController extends Controller
{
    use ChecksBadgeUnlock;

    public function index()
    {
        $student = Auth::user()->student;

        // 🔓 Cek dan unlock semua badge sesuai kondisi
        $this->checkAndUnlockBadges($student);

        // Ambil semua badge dan yang dimiliki student
        $allBadges = Badge::all();
        $ownedBadges = $student->badges->pluck('id')->toArray();

        return view('student.badge.choose-badge', compact('allBadges', 'ownedBadges'));
    }
}
