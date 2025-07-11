@extends('teacher.layouts.app')

@section('content')
<div class="min-h-screen py-6 px-4 sm:px-6">
    <div class="max-w-screen-lg mx-auto">

        <a href="{{ route('teacher.student-progress.detail', $student->id) }}"
           class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2 rounded-full text-sm font-medium shadow transition mb-4 sm:mb-6">
            ← Back to Student Progress
        </a>

        <h2 class="text-center text-2xl sm:text-3xl font-bold text-yellow-900 mb-6">
            📄 Student Answers - {{ $student->user->name ?? '-' }}
        </h2>

        @forelse ($groupedAnswers as $storyId => $stages)
            @php
                $storyTitle = optional($stages->first()->first()->first()->question->stage->story)->title ?? 'Story';
            @endphp

            <div class="mb-6 rounded-xl shadow ring-1 ring-yellow-200 bg-yellow-50 overflow-hidden">
                <button onclick="toggleStory('{{ $storyId }}')"
                    class="w-full text-left px-4 py-3 sm:px-6 sm:py-4 bg-yellow-100 hover:bg-yellow-200 text-yellow-900 font-semibold text-base sm:text-lg transition">
                    📘 {{ $storyTitle }}
                </button>

                <div id="story-{{ $storyId }}" class="hidden">
                    @foreach ($stages as $stageId => $questions)
                        @php
                            $stageOrder = optional($questions->first()->first()->question->stage)->order ?? '-';
                        @endphp

                        <div class="border-t border-yellow-200">
                            <button onclick="toggleStage('{{ $storyId }}-{{ $stageId }}')"
                                class="w-full text-left px-4 py-3 sm:px-6 bg-yellow-200 hover:bg-yellow-300 text-yellow-900 font-medium transition">
                                🧩 Stage {{ $stageOrder }}
                            </button>

                            <div id="stage-{{ $storyId }}-{{ $stageId }}" class="hidden px-4 sm:px-6 py-4 space-y-6">

                                @foreach ($questions as $questionId => $attempts)
                                    <div class="bg-white border border-yellow-300 rounded-xl shadow-sm p-4">
                                        <div class="mb-3">
                                            <p class="text-yellow-900 font-semibold">❓ Question: {{ $attempts->first()->question->question_text }}</p>
                                        </div>

                                        @foreach ($attempts as $attempt)
                                            <div class="border border-gray-200 rounded-md p-3 mb-3 bg-gray-50">
                                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-2 text-sm gap-2 sm:gap-0">
                                                    <div class="font-medium text-gray-700">
                                                        Attempt #{{ $attempt->attempt }}
                                                    </div>
                                                    <div class="flex flex-wrap items-center gap-2 text-sm">
                                                        <span class="{{ $attempt->is_correct ? 'text-green-600' : 'text-red-600' }} font-semibold">
                                                            {{ $attempt->is_correct ? '✅ Correct' : '❌ Incorrect' }}
                                                        </span>
                                                        <span class="text-yellow-800">Score: {{ $attempt->score_earned }}</span>
                                                        <span class="text-gray-500">{{ $attempt->created_at->format('d M Y, H:i') }}</span>
                                                    </div>
                                                </div>

                                                <ul class="space-y-1 text-sm mt-2">
                                                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                                                        @php
                                                            $optText = $attempt->question->{'option_' . strtolower($opt)};
                                                            $isSelected = $attempt->selected_option === $opt;
                                                            $isCorrect = $attempt->question->correct_answer === $opt;

                                                            $bgClass = '';
                                                            $textClass = 'text-yellow-900';

                                                            if ($isCorrect && $isSelected) {
                                                                $bgClass = 'bg-green-200 border-l-4 border-green-600';
                                                                $textClass = 'text-green-800 font-semibold';
                                                            } elseif ($isCorrect) {
                                                                $bgClass = 'bg-green-100';
                                                                $textClass = 'text-green-700';
                                                            } elseif ($isSelected) {
                                                                $bgClass = 'bg-red-100 border-l-4 border-red-500';
                                                                $textClass = 'text-red-700 font-semibold';
                                                            }
                                                        @endphp

                                                        <li class="p-2 rounded {{ $bgClass }}">
                                                            <span class="font-semibold">{{ $opt }}.</span>
                                                            <span class="{{ $textClass }}">{{ $optText }}</span>

                                                            @if ($isCorrect)
                                                                <span class="ml-2 text-green-600 font-semibold">✅ Correct Answer</span>
                                                            @endif

                                                            @if ($isSelected && !$isCorrect)
                                                                <span class="ml-2 text-red-600 font-semibold">👤 Student's Answer</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-yellow-800 font-medium bg-yellow-100 p-4 rounded-xl shadow text-center">❗ No answers submitted by this student yet.</p>
        @endforelse
    </div>
</div>

{{-- Toggle Script --}}
<script>
    function toggleStory(id) {
        document.getElementById('story-' + id).classList.toggle('hidden');
    }

    function toggleStage(id) {
        document.getElementById('stage-' + id).classList.toggle('hidden');
    }
</script>
@endsection
