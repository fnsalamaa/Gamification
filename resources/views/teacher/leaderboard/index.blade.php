@extends('teacher.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-brown-700">🏆 Leaderboard</h1>

    {{-- Tabs --}}
    <div class="mb-6 flex flex-wrap gap-2">
    <a href="{{ route('teacher.leaderboard', ['type' => 'story']) }}"
        class="w-full sm:w-auto text-center px-4 py-2 rounded-lg font-semibold {{ $type === 'story' ? 'bg-yellow-800 text-white' : 'bg-gray-200 text-gray-700' }}">
        Story Leaderboard
    </a>
    <a href="{{ route('teacher.leaderboard', ['type' => 'global']) }}"
        class="w-full sm:w-auto text-center px-4 py-2 rounded-lg font-semibold {{ $type === 'global' ? 'bg-yellow-800 text-white' : 'bg-gray-200 text-gray-700' }}">
        Global Leaderboard
    </a>
    </div>


    {{-- Leaderboard Content --}}
    @if ($type === 'global')
        <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
            <h2 class="text-xl font-bold mb-4 text-brown-700 flex items-center gap-2">🌐 Global Leaderboard</h2>

            @if ($students->isEmpty())
                <p class="text-gray-500 italic">Belum ada data skor.</p>
            @else
                {{-- TABEL DESKTOP --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 rounded-md overflow-hidden">
                        <thead class="bg-yellow-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">🏅 Rank</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">Class</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">Score</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach ($students as $i => $student)
                                @php
                                    $rank = $students->firstItem() + $i;
                                    $rowClass = match($rank) {
                                        1 => 'bg-yellow-100 font-bold',
                                        2 => 'bg-yellow-50',
                                        3 => 'bg-gray-50',
                                        default => '',
                                    };
                                    $badgeColor = match($rank) {
                                        1 => 'bg-yellow-700',
                                        2 => 'bg-yellow-600',
                                        3 => 'bg-yellow-500',
                                        default => 'bg-gray-500',
                                    };
                                @endphp
                                <tr class="{{ $rowClass }} hover:bg-yellow-50 transition">
                                    <td class="px-6 py-3 text-sm text-gray-700">{{ $rank }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-700">{{ $student->user->name }}</td>
                                    <td class="px-6 py-3 text-sm text-gray-700">{{ $student->class }}</td>
                                    <td class="px-6 py-3">
                                        <span class="inline-block px-3 py-1 text-sm font-semibold text-white {{ $badgeColor }} rounded-full shadow">
                                            {{ $student->total_score }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- CARD MOBILE --}}
                <div class="sm:hidden space-y-4 mt-4">
                    @foreach ($students as $i => $student)
                        @php
                            $rank = $students->firstItem() + $i;
                            $badgeColor = match($rank) {
                                1 => 'bg-yellow-700',
                                2 => 'bg-yellow-600',
                                3 => 'bg-yellow-500',
                                default => 'bg-gray-500',

                            };
                        @endphp
                        <div class="bg-white p-4 rounded-xl shadow flex items-center justify-between border-l-4 {{ $badgeColor }}">
                            <div>
                                <div class="text-sm font-semibold text-gray-700">#{{ $rank }} - {{ $student->user->name }}</div>
                                <div class="text-xs text-gray-500 mt-1">Class: {{ $student->class }}</div>
                            </div>
                            <div class="text-white text-sm font-bold px-3 py-1 rounded-full {{ $badgeColor }}">
                                {{ $student->total_score }}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $students->links() }}
                </div>
            @endif
        </div>

    @else
        {{-- Filter Dropdown Pilih Story --}}
        <form method="GET" action="{{ route('teacher.leaderboard') }}" class="mb-6">
            <input type="hidden" name="type" value="story">
            <label for="story_id" class="block mb-2 font-semibold text-gray-700">🎯 Select Story</label>
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
                        $storyStudents  = $data['students'];
                    @endphp

                    <div class="bg-white p-6 rounded-xl shadow">
                        <h2 class="text-lg font-bold mb-3 text-brown-700">📖 {{ $story->title }}</h2>

                        {{-- DESKTOP --}}
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-yellow-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">🏅 Rank</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">Class</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-brown-700 uppercase tracking-wider">Score</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($storyStudents as $i => $studentData)
                                        @php
                                            $rank = $storyStudents->firstItem() + $i;
                                            $rowClass = match($rank) {
                                                1 => 'bg-yellow-100 font-bold',
                                                2 => 'bg-yellow-50',
                                                3 => 'bg-gray-50',
                                                default => '',
                                            };
                                            $badgeColor = match($rank) {
                                                1 => 'bg-yellow-700',
                                                2 => 'bg-yellow-600',
                                                3 => 'bg-yellow-500',
                                                default => 'bg-gray-500',
                                            };
                                        @endphp
                                        <tr class="{{ $rowClass }} hover:bg-yellow-50 transition">
                                            <td class="px-6 py-3 text-sm text-gray-800">{{ $rank }}</td>
                                            <td class="px-6 py-3 text-sm text-gray-800">{{ $studentData->student->user->name ?? 'Unknown' }}</td>
                                            <td class="px-6 py-3 text-sm text-gray-800">{{ $studentData->student->class ?? '-' }}</td>
                                            <td class="px-6 py-3">
                                                <span class="inline-block px-3 py-1 text-sm font-semibold text-white {{ $badgeColor }} rounded-full shadow">
                                                    {{ $studentData->total_score }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- MOBILE --}}
                        <div class="sm:hidden space-y-4 mt-4">
                            @foreach ($storyStudents as $i => $studentData)

                                @php
                                    
                                    $rank = $storyStudents->firstItem() + $i;

                                    $badgeColor = match($rank) {
                                        1 => 'bg-yellow-700',
                                        2 => 'bg-yellow-600',
                                        3 => 'bg-yellow-500',
                                        default => 'bg-gray-500',


                                    };
                                @endphp
                                <div class="bg-white p-4 rounded-xl shadow flex items-center justify-between border-l-4 {{ $badgeColor }}">
                                    <div>
                                        <div class="text-sm font-semibold text-gray-700">#{{ $rank }} - {{ $studentData->student->user->name ?? 'Unknown' }}</div>
                                        <div class="text-xs text-gray-500 mt-1">Class: {{ $studentData->student->class ?? '-' }}</div>

                                    </div>
                                    <div class="text-white text-sm font-bold px-3 py-1 rounded-full {{ $badgeColor }}">
                                        {{ $studentData->total_score }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4">
                            {{ $storyStudents->links() }}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Please select a story to view the leaderboard.</p>
        @endif
    @endif
</div>
@endsection
