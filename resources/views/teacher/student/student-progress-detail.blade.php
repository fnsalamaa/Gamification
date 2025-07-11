@extends('teacher.layouts.app')

@section('content')
    <div class=" min-h-screen py-10 px-4">
        <div class="max-w-screen-lg mx-auto">
            <a href="{{ route('teacher.students.show') }}"
                class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-full text-sm font-medium shadow transition mb-6">
                ← Back to Student List
            </a>
            <h2 class="text-center text-3xl font-bold text-yellow-900 mb-6">📊 Student Progress</h2>



            <div class="bg-white rounded-2xl shadow-xl p-6 ring-1 ring-yellow-200">
                <p class="text-lg font-semibold text-yellow-900 mb-6">
                    👩‍🎓 Name: <span class="font-bold">{{ $student->user->name ?? '-' }}</span>
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                    <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl shadow flex flex-col items-center">
                        <span class="text-sm uppercase tracking-wide font-semibold">Total Answers</span>
                        <span class="text-3xl font-bold mt-2">{{ $progress['answered'] }}</span>
                    </div>
                    <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl shadow flex flex-col items-center">
                        <span class="text-sm uppercase tracking-wide font-semibold">Correct Answers</span>
                        <span class="text-3xl font-bold mt-2">{{ $progress['correct'] }}</span>
                    </div>
                    <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl shadow flex flex-col items-center">
                        <span class="text-sm uppercase tracking-wide font-semibold">Total Score</span>
                        <span class="text-3xl font-bold mt-2">{{ $progress['score'] }}</span>
                    </div>
                    <div class="bg-yellow-100 text-yellow-800 p-6 rounded-xl shadow flex flex-col items-center">
                        <span class="text-sm uppercase tracking-wide font-semibold">Global Rank</span>
                        <span class="text-3xl font-bold mt-2">{{ $progress['rank'] }}</span>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('teacher.student.answer.detail', $student->id) }}"
                        class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-full text-sm font-medium shadow transition">
                        📄 View All Answers
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection