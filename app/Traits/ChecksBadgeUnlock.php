<?php

namespace App\Traits;

use App\Models\Badge;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

trait ChecksBadgeUnlock
{
    public function checkAndUnlockBadges($student)
    {
        $newlyUnlocked = [];

        // 👋 Welcome Aboard
        $this->unlockBadgeIfNotYet($student, 'first_login', $newlyUnlocked);

        // 👣 First Step
        $answeredStoryCount = DB::table('student_answers')
            ->join('questions', 'student_answers.question_id', '=', 'questions.id')
            ->join('stages', 'questions.stage_id', '=', 'stages.id')
            ->join('stories', 'stages.story_id', '=', 'stories.id')
            ->where('student_answers.student_id', $student->id)
            ->distinct('stories.id')
            ->count('stories.id');

        if ($answeredStoryCount >= 1) {
            $this->unlockBadgeIfNotYet($student, 'read_first_story', $newlyUnlocked);
        }

        // 🎓 Folklores Master
        $stories = DB::table('stories')->pluck('id');
        $completedAllStories = true;

        foreach ($stories as $storyId) {
            $totalQuestions = DB::table('questions')
                ->join('stages', 'questions.stage_id', '=', 'stages.id')
                ->where('stages.story_id', $storyId)
                ->count();

            $answered = DB::table('student_answers')
                ->join('questions', 'student_answers.question_id', '=', 'questions.id')
                ->join('stages', 'questions.stage_id', '=', 'stages.id')
                ->where('student_answers.student_id', $student->id)
                ->where('stages.story_id', $storyId)
                ->distinct('student_answers.question_id')
                ->count('student_answers.question_id');

            if ($answered < $totalQuestions) {
                $completedAllStories = false;
                break;
            }
        }

        if ($completedAllStories) {
            $this->unlockBadgeIfNotYet($student, 'complete_all_stories', $newlyUnlocked);
        }

        // ⚡ Fast Learner
        $correctAnswers = DB::table('student_answers')
            ->where('student_id', $student->id)
            ->where('is_correct', true)
            ->where('attempt', 1)
            ->distinct('question_id')
            ->count('question_id');

        $totalQuestions = DB::table('questions')->count();
        if ($totalQuestions > 0 && $correctAnswers === $totalQuestions) {
            $this->unlockBadgeIfNotYet($student, 'answer_all_correct_first_try', $newlyUnlocked);
        }

        // 🎯 Story-based score 100
        $storyScores = DB::table('student_answers')
            ->join('questions', 'student_answers.question_id', '=', 'questions.id')
            ->join('stages', 'questions.stage_id', '=', 'stages.id')
            ->join('stories', 'stages.story_id', '=', 'stories.id')
            ->where('student_answers.student_id', $student->id)
            ->select('stories.title', DB::raw('SUM(score_earned) as total_score'))
            ->groupBy('stories.title')
            ->pluck('total_score', 'title');

        foreach (['Ande Ande Lumut', 'Sangkuriang', 'Timun Mas', 'Roro Jonggrang', 'Cindelaras', 'Telaga Sarangan'] as $title) {
            if (($storyScores[$title] ?? 0) >= 100) {
                $this->unlockBadgeIfNotYet($student, 'score_100_' . strtolower(str_replace(' ', '_', $title)), $newlyUnlocked);
            }
        }

        

        // 🏆 Final Leaderboard Ranking
        $rankedStudents = DB::table('students')
            ->leftJoin('student_answers', 'students.id', '=', 'student_answers.student_id')
            ->select('students.id', DB::raw('COALESCE(SUM(student_answers.score_earned), 0) as total_score'))
            ->groupBy('students.id')
            ->orderByDesc('total_score')
            ->get();

        $studentId = (int) $student->id;
        $studentRank = $rankedStudents
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->search($studentId);

        $studentRank = $studentRank === false ? null : $studentRank + 1;

        // Reset all rank badges (note: reach_top_10 belum dihapus di sini)
        $this->removeBadge($student, 'rank_1_final');
        $this->removeBadge($student, 'rank_1_all_stories');
        $this->removeBadge($student, 'rank_2_final');
        $this->removeBadge($student, 'rank_3_final');

        // Unlock sesuai peringkat
        if ($studentRank === 1) {
            $this->unlockBadgeIfNotYet($student, 'rank_1_final', $newlyUnlocked);
            $this->unlockBadgeIfNotYet($student, 'rank_1_all_stories', $newlyUnlocked);
        } elseif ($studentRank === 2) {
            $this->unlockBadgeIfNotYet($student, 'rank_2_final', $newlyUnlocked);
        } elseif ($studentRank === 3) {
            $this->unlockBadgeIfNotYet($student, 'rank_3_final', $newlyUnlocked);
        }

        // 🧗 The Climber (Top 10)
        $topTenIds = DB::table('students')
            ->where('total_score', '>', 0)
            ->orderByDesc('total_score')
            ->limit(10)
            ->pluck('id')
            ->toArray();

        $this->removeBadge($student, 'reach_top_10'); // Baru di sini dihapus (paling akhir)

        if ($student->total_score > 0 && in_array($student->id, $topTenIds)) {
            $this->unlockBadgeIfNotYet($student, 'reach_top_10', $newlyUnlocked);
        }

        return $newlyUnlocked;
    }


    protected function unlockBadgeIfNotYet($student, $condition, &$unlockedList = [])
    {
        $badge = Badge::where('unlock_condition', $condition)->first();
        if (!$badge)
            return;

        $exists = $student->badges()
            ->wherePivot('badge_id', $badge->id)
            ->wherePivot('is_unlocked', true)
            ->exists();

        if (!$exists) {
            $student->badges()->syncWithoutDetaching([
                $badge->id => [
                    'is_unlocked' => true,
                    'unlocked_at' => now(),
                    'awarded_at' => now()
                ]
            ]);
            Log::info("Badge {$badge->name} unlocked for student {$student->id}");
            $unlockedList[] = $badge->name;
        }
    }

    protected function removeBadge($student, $condition)
    {
        $badge = Badge::where('unlock_condition', $condition)->first();
        if ($badge) {
            $student->badges()->detach($badge->id);
            Log::info("Badge {$badge->name} removed from student {$student->id}");
        }
    }
}
