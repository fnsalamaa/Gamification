@extends('student.layouts.app')

@section('content')


    <div class="max-w-3xl mx-auto px-4 py-8">

        {{-- Title --}}
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-indigo-700">{{ $story->title }}</h1>
        </div>

        {{-- Progress Bar --}}
        @php
            $stageIndex = request('stage', 0);
            $questionIndex = request('question', 0);
            $currentStage = $stages[$stageIndex];
            $questions = $currentStage->questions;
            $totalQuestions = count($questions);
            $progress = ($questionIndex + 1) / ($totalQuestions ?: 1) * 100;
        @endphp

        {{-- 🎮 Game Style Progress Bar --}}
        <div
            class="relative w-full bg-gray-300/50 border border-indigo-600 rounded-xl h-6 overflow-hidden shadow-inner backdrop-blur-sm mb-6">
            <div class="absolute inset-0 z-10 flex items-center justify-center text-xs font-bold text-white drop-shadow-sm">
                🧠 Progress: {{ $questionIndex + 1 }} / {{ $totalQuestions }} ({{ round($progress) }}%)
            </div>
            <div class="h-full transition-all duration-700 ease-in-out bg-gradient-to-r from-purple-700 via-indigo-500 to-blue-500"
                style="width: {{ $progress }}%">
            </div>
        </div>

        {{-- Stage Navigation --}}
        @php
            $sessionKey = 'completed_stages_' . $story->id;
            $completedStages = session($sessionKey, []);

            // Tambahkan stage saat ini ke daftar unlocked jika belum ada
            if (!in_array($stageIndex, $completedStages)) {
                $completedStages[] = $stageIndex;
                session([$sessionKey => $completedStages]);
            }

            // Tentukan maksimum stage yang pernah diselesaikan
            $maxUnlocked = max($completedStages ?? [0]);
        @endphp

        <div class="flex justify-center gap-4 my-6">
            @foreach ($stages as $index => $stage)
                @php
                    $isUnlocked = $index <= $maxUnlocked;
                    $isActive = $stageIndex == $index;
                @endphp

                <div class="group text-center">
                    <a href="{{ $isUnlocked ? request()->fullUrlWithQuery(['stage' => $index, 'question' => 0]) : '#' }}" class="block w-20 h-20 rounded-xl transition shadow-md p-2 transform hover:scale-105
                                                                                                                                                                                        {{ $isActive
                ? 'bg-indigo-600 text-white border-2 border-indigo-700'
                : ($isUnlocked
                    ? 'bg-white text-indigo-700 border border-indigo-300 hover:bg-indigo-100'
                    : 'bg-gray-100 text-gray-400 border border-gray-300 cursor-not-allowed') }}"
                        title="{{ $isUnlocked ? 'Stage ' . $stage->order : '🔒 Locked' }}">

                        <div class="text-xl font-bold">{{ $stage->order }}</div>
                        <div class="text-sm">
                            @if ($isActive)
                                🎯 Active
                            @elseif ($isUnlocked)
                                ✅ Unlocked
                            @else
                                🔒 Locked
                            @endif
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- LOAD QUESTION --}}
        @php
            $question = $questions[$questionIndex] ?? null;
        @endphp

        @if ($question)

            {{-- NARRATIVE --}}
            @if ($question->narrative)
                <div class="bg-yellow-50 border-2 border-yellow-300 rounded-xl p-4 mb-6 shadow">
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 text-lg mr-2">📖</span>
                        <h3 class="text-md font-semibold text-yellow-700">Narrative</h3>
                    </div>
                    <p class="text-gray-700 italic">{{ $question->narrative }}</p>
                    @if ($question->image)
                        <div class="mb-4 flex justify-center">
                            <img src="{{ asset('storage/' . $question->image) }}" alt="🖼️ Question Image"
                                class="w-64 h-auto rounded-lg border shadow">
                        </div>
                    @endif
                </div>
            @endif

            {{-- QUESTION --}}
            <div class="bg-white border-2 border-indigo-300 rounded-xl p-6 mb-6 shadow">
                <div class="flex items-center mb-2">
                    <span class="text-indigo-500 text-lg mr-2">🧠</span>
                    <h3 class="text-md font-semibold text-indigo-700">Question</h3>
                </div>
                <p class="text-lg text-gray-800 font-medium">{{ $question->question_text }}</p>
            </div>

            @php
                $student = auth()->user()->student;

                $attempts = \App\Models\StudentAnswer::where('student_id', $student->id)
                    ->where('question_id', $question->id)
                    ->count();
                $disabled = $attempts >= 3;
            @endphp

            @php
                $student = auth()->user()->student;
                $answers = \App\Models\StudentAnswer::where('student_id', $student->id)
                    ->where('question_id', $question->id)
                    ->orderByDesc('created_at')
                    ->get();

                $attempts = $answers->count();
                $isCorrect = $answers->first()?->is_correct ?? false;
                $disabled = $attempts >= 3 || $isCorrect;
            @endphp

            @php
                $hasAnswered = \App\Models\StudentAnswer::where('student_id', $student->id)
                    ->where('question_id', $question->id)
                    ->exists();
            @endphp



            {{-- ANSWER OPTIONS --}}
            <form method="POST" action="{{ route('student.answer.submit', $question->id) }}" x-data="{ selected: '' }">
                @csrf

                <div class="space-y-3">
                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                        <label
                            :class="selected === '{{ $opt }}' ? 'bg-yellow-200 border-yellow-500 font-bold text-yellow-800' : 'bg-white hover:bg-indigo-100 border-indigo-300'"
                            class="block border-2 px-4 py-2 rounded-full transition shadow-sm cursor-pointer {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <input type="radio" name="selected_option" value="{{ $opt }}" class="hidden" x-model="selected" {{ $disabled ? 'disabled' : '' }}>
                            <strong>{{ $opt }}.</strong> {{ $question->{'option_' . strtolower($opt)} }}
                        </label>


                    @endforeach
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-indigo-600 text-white font-bold px-6 py-2 rounded hover:bg-indigo-700 shadow {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $disabled ? 'disabled' : '' }}>
                        Submit Jawaban
                    </button>


                </div>

            </form>

            @if (session('success'))
                <div class="mt-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 font-semibold">
                    ✅ {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="mt-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 font-semibold">
                    ❌ {{ session('error') }}
                </div>
            @endif




            {{-- Navigation Buttons --}}
        
            <div class="flex justify-between mt-6">
                {{-- Tombol Sebelumnya --}}
                @if ($questionIndex > 0)
                    <a href="{{ request()->fullUrlWithQuery(['question' => $questionIndex - 1]) }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-4 py-2 rounded shadow">
                        ⬅️ Previous
                    </a>
                @else
                    <div></div>
                @endif

                {{-- Tombol Berikutnya atau Selesai --}}
                @if ($questionIndex + 1 < $totalQuestions)
                    {{-- Kalau masih ada soal berikutnya --}}
                    @if ($hasAnswered)
                        <a href="{{ request()->fullUrlWithQuery(['question' => $questionIndex + 1]) }}"
                            class="ml-auto bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-4 py-2 rounded shadow">
                            Next ➡️
                        </a>
                    @else
                        <button disabled
                            class="ml-auto bg-gray-300 text-gray-500 font-semibold px-4 py-2 rounded shadow cursor-not-allowed">
                            📌 Jawab dulu sebelum lanjut
                        </button>
                    @endif
                @else
                    {{-- Ini adalah soal terakhir --}}
                    @if ($hasAnswered)
                        @if ($stageIndex + 1 < count($stages))
                            {{-- Masih ada stage berikutnya --}}
                            <a href="{{ request()->fullUrlWithQuery(['question' => 0, 'stage' => $stageIndex + 1]) }}"
                                class="ml-auto bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded shadow">
                                ✅ Finish Stage
                            </a>
                        @else
                            {{-- Sudah di stage terakhir, arahkan ke leaderboard --}}
                            <a href="{{ route('student.leaderboard.show', ['story' => $story->id]) }}"
                                class="ml-auto bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded shadow">
                                🏁 Selesai! Lihat Hasil
                            </a>
                        @endif
                    @else
                        <button disabled
                            class="ml-auto bg-gray-300 text-gray-500 font-semibold px-4 py-2 rounded shadow cursor-not-allowed">
                            📌 Jawab dulu sebelum lanjut
                        </button>
                    @endif
                @endif
            </div>


        @else
            <p class="text-red-500 text-center">❗ Question not found.</p>
        @endif

        {{-- MODAL RESULT POINT --}}
        @if (request('show_result') === 'true')
            @php
                $totalScore = \App\Models\StudentAnswer::where('student_id', auth()->user()->student->id)
                    ->whereIn('question_id', $story->stages->flatMap->questions->pluck('id'))
                    ->sum('score_earned');
            @endphp

            <div x-data="{ open: true }">
                <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded-2xl p-8 shadow-lg text-center w-96">
                        <h2 class="text-2xl font-bold text-indigo-700 mb-4">🎉 Selamat!</h2>
                        <p class="text-lg text-gray-700 mb-2">Kamu telah menyelesaikan <strong>{{ $story->title }}</strong></p>
                        <p class="text-lg text-indigo-600 font-semibold mb-4">Total Poin: {{ $totalScore }}</p>
                        <a href="{{ route('student.leaderboard', $story->id) }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-2 rounded shadow inline-block">
                            🏆 Lihat Leaderboard
                        </a>

                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection