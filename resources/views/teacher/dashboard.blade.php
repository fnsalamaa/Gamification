@extends('teacher.layouts.app')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Students -->
    <a href="{{ route('teacher.students.show') }}"
        class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-4xl">👥</div>
            <div class="text-sm font-medium">Total Students</div>
            <div class="text-2xl font-bold">{{ $totalStudents }}</div>
        </div>
    </a>

    <!-- Total Stories -->
    <a href="{{ route('teacher.story.index') }}"
        class="bg-gradient-to-r from-pink-500 to-red-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-4xl">📚</div>
            <div class="text-sm font-medium">Total Stories</div>
            <div class="text-2xl font-bold">{{ $totalStories }}</div>
        </div>
    </a>

    <!-- Total Questions -->
    <a href="{{ route('teacher.story.index') }}"
        class="bg-gradient-to-r from-teal-500 to-emerald-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-4xl">❓</div>
            <div class="text-sm font-medium">Total Questions</div>
            <div class="text-2xl font-bold">{{ $totalQuestions }}</div>
        </div>
    </a>

    <!-- Global Leaderboard -->
    <a href="{{ route('teacher.leaderboard', ['type' => 'global']) }}"
        class="bg-gradient-to-r from-yellow-500 to-orange-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
        <div class="flex flex-col items-center space-y-2">
            <div class="text-4xl">🏆</div>
            <div class="text-sm font-medium">Leaderboard</div>
            <div class="text-2xl font-bold">View</div>
        </div>
    </a>
</div>
@endsection
