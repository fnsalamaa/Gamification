<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Badge;
class BadgeController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        // Cek dan tambahkan badge "Welcome Aboard" jika belum dimiliki
        $welcomeBadge = Badge::where('name', '👋 Welcome Aboard')->first();

        if ($welcomeBadge && !$student->badges->contains($welcomeBadge->id)) {
            $student->badges()->attach($welcomeBadge->id, [
                'awarded_at' => now(),
            ]);
        }

        // Ambil semua badge dan yang dimiliki student
        $allBadges = Badge::all();
        $ownedBadges = $student->badges->pluck('id')->toArray();


        return view('student.badge.choose-badge', compact('allBadges', 'ownedBadges'));
    }



}
