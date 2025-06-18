@extends('teacher.layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6 text-indigo-700">🏆 Leaderboard</h1>

        {{-- Tabs --}}
        <div class="mb-6 flex space-x-4">
            <a href="{{ route('teacher.leaderboard', ['type' => 'story']) }}"
                class="px-4 py-2 rounded-lg font-semibold {{ $type === 'story' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                Story Leaderboard
            </a>
            <a href="{{ route('teacher.leaderboard', ['type' => 'global']) }}"
                class="px-4 py-2 rounded-lg font-semibold {{ $type === 'global' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                Global Leaderboard
            </a>
        </div>

        {{-- Leaderboard Content --}}
        @if ($type === 'global')
            <div class="bg-white p-6 rounded-xl shadow">
                <h2 class="text-xl font-bold mb-4 text-brown-700">🌐 Global Leaderboard</h2>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Score</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($students as $i => $student)
                            <tr>
                                <td class="px-4 py-2">{{ $i + 1 }}</td>
                                <td class="px-4 py-2">{{ $student->user->name }}</td>
                                <td class="px-4 py-2 font-semibold">{{ $student->student_answers_sum_score_earned }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- Filter Dropdown Pilih Story --}}
            <form method="GET" action="{{ route('teacher.leaderboard') }}" class="mb-6">
                <input type="hidden" name="type" value="story">
                <label for="story_id" class="block mb-2 font-semibold text-gray-700">🎯 Pilih Story</label>
                <select name="story_id" id="story_id" onchange="this.form.submit()" class="border rounded-lg p-2 w-64">
                    <option value="">-- Select Story --</option>
                    @foreach ($stories as $story)
                        <option value="{{ $story->id }}" {{ (int) $selectedStoryId === $story->id ? 'selected' : '' }}>
                            {{ $story->title }}
                        </option>
                    @endforeach
                </select>
            </form>

            @if ($selectedStoryId)
                <div class="space-y-8">
                    @foreach ($storyScores as $data)
                        @php
                            $story = $data['story'];
                            $students = $data['students'];
                        @endphp

                        <div class="bg-white p-6 rounded-xl shadow">
                            <h2 class="text-lg font-bold mb-3 text-brown-700">📖 {{ $story->title }}</h2>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left">#</th>
                                        <th class="px-4 py-2 text-left">Name</th>
                                        <th class="px-4 py-2 text-left">Score</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($students as $i => $studentData)
                                        <tr>
                                            <td class="px-4 py-2">{{ $i + 1 }}</td>
                                            <td class="px-4 py-2">{{ $studentData->student->user->name ?? 'Unknown' }}</td>
                                            <td class="px-4 py-2 font-semibold">{{ $studentData->total_score }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">Please select a story to view the leaderboard.</p>
            @endif
        @endif
    </div>
@endsection
