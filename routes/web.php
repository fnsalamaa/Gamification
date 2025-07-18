<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Teacher\TeacherController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\administrator;
use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\admin\StoryController;
use App\Http\Controllers\admin\QuestionController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\student\StudentController;
use App\Http\Controllers\Student\ChooseStoryController;
use App\Http\Controllers\Student\StudentAnswerController;
use App\Http\Controllers\Student\StudentAvatarController;
use App\Http\Controllers\Student\BadgeController;
use App\Http\Controllers\Student\LeaderboardController;

use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');


//Admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashBoardController::class, 'index'])->name('admin.dashboard');

    // Story
    Route::get('/create-story', [StoryController::class, 'index'])->name('admin.create-story');
    Route::post('/store-story', [StoryController::class, 'store'])->name('admin.store-story');
    Route::put('/story/{id}', [StoryController::class, 'update'])->name('admin.update-story');
    Route::delete('/story/{id}', [StoryController::class, 'destroy'])->name('admin.delete-story');
    Route::get('/story/{id}/detail', [StoryController::class, 'addDetail'])->name('admin.detail-story');
    Route::post('/story/{id}/detail', [StoryController::class, 'storeDetail'])->name('admin.store-detail');

    // Question
    Route::post('/stages/{id}/questions', [QuestionController::class, 'storeMultiple'])->name('admin.questions.store');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('admin.questions.edit');
    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('admin.questions.update');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('admin.questions.destroy');

    // Manage user
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.show-users');
    Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');


});

// Student
Route::prefix('student')->middleware(['auth', 'verified', 'role:student'])->group(function () {
    // Dashboard & Story
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    // Route::get('/choose-story', [ChooseStoryController::class, 'index'])->name('student.story.chooseStory');
    // Route::get('/choose-story/{id}', [ChooseStoryController::class, 'show'])->name('student.story.show');

    // Quiz List semua story
    Route::get('/choose-story', [ChooseStoryController::class, 'index'])->name('student.story.chooseStory');
    Route::get('/choose-story/{story}', [ChooseStoryController::class, 'showQuiz'])->name('student.story.readStory');
    Route::post('/question/{question}/answer', [StudentController::class, 'submitAnswer'])->name('student.answer.submit');

    // Leaderboard route
    Route::get('/leaderboard/{story}', [LeaderboardController::class, 'show'])
        ->name('student.leaderboard.show');
    Route::get('/leaderboard-global', [LeaderboardController::class, 'global'])
    ->name('student.leaderboard.global');
    
    // Avatars
    Route::get('/choose-avatar', [StudentAvatarController::class, 'index'])->name('student.avatar.choose');
    Route::post('/choose-avatar/{id}', [StudentAvatarController::class, 'select'])->name('student.avatar.select');

    // Badges
    Route::get('/choose-badge', [BadgeController::class, 'index'])->name('student.badge.choose');

    // Profile
    Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('student.profile.edit');
    Route::post('/profile/update', [StudentController::class, 'updateProfile'])->name('student.profile.update');

});

// Teacher
Route::prefix('teacher')->middleware(['auth', 'verified', 'role:teacher'])->group(function () {
    // Dashboard & Story
    Route::get('/dashboard', [TeacherController::class, 'index'])->name('teacher.dashboard');

    // Student
    Route::get('/students', [TeacherController::class, 'showAllStudents'])->name('teacher.students.show');
    Route::get('/student-answer/{id}', [TeacherController::class, 'showStudentAnswerDetail'])->name('teacher.student.answer.detail');
    Route::get('/student-progress/{id}', [TeacherController::class, 'showStudentProgressDetail'])->name('teacher.student-progress.detail');



    // Halaman  story
    Route::get('/story', [TeacherController::class, 'showAllStories'])->name('teacher.story.index');
    Route::get('/story/{id}', [TeacherController::class, 'showStoryDetail'])->name('teacher.story.detail');

     // Leaderboard
    Route::get('/leaderboard', [TeacherController::class, 'showLeaderboard'])->name('teacher.leaderboard');

});

require __DIR__ . '/auth.php';

Route::middleware('auth')->get('/redirect-after-login', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('student')) {
        return redirect()->route('student.dashboard');
    } elseif ($user->hasRole('teacher')) {
        return redirect()->route('teacher.dashboard');
    }

    return redirect('/');
})->name('redirect.after.login');
