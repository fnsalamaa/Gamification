@extends('student.layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6 relative">
        <!-- Background -->
        <div class="absolute inset-0 opacity-10 bg-[url('/images/bg-leaderboard.png')] bg-cover bg-center pointer-events-none"></div>

        <h1 class="text-3xl font-extrabold mb-6 text-center text-indigo-700 relative z-10">🏆 Leaderboard</h1>
        <p class="text-center text-gray-600 mb-6 relative z-10">
            📖 Story: <strong>{{ $story->title }}</strong>
        </p>

        <div class="relative z-10 mb-6">
            <a href="{{ route('student.leaderboard.global') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg transition duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Global Leaderboard
            </a>
        </div>

        <!-- Podium -->
        @php
            $topThree = $students->take(3);
            $colors = ['bg-yellow-400', 'bg-gray-400', 'bg-amber-500'];
            $heights = ['h-40', 'h-32', 'h-28'];
            $emojis = ['🥇', '🥈', '🥉'];
            $visualOrder = [1, 0, 2];
        @endphp

        <div class="relative z-10 flex justify-center items-end gap-6 mb-10">
            @foreach ($visualOrder as $rankIndex)
                @php $student = $topThree[$rankIndex] ?? null; @endphp
                @if ($student)
                    @php
                        $avatarPath = $student['avatar_path'] ?? '';
                        $avatarUrl = (!$avatarPath || in_array($avatarPath, ['default.png', 'special.jpg']))
                            ? asset('storage/avatars/special.jpg')
                            : asset('storage/' . $avatarPath);
                    @endphp

                    <div class="flex flex-col items-center transition-transform transform hover:scale-105 duration-300">
                        <img src="{{ $avatarUrl }}" class="w-12 h-12 rounded-full border-4 border-white shadow-lg object-cover">
                        <div class="mt-2 text-sm font-semibold text-gray-800 text-center">{{ $student['name'] }}</div>
                        <div class="text-xs text-gray-500 mb-1">Score: {{ $student['score'] }}</div>
                        <div class="text-[10px] text-gray-400 -mt-1">
                            @if (!empty($student['latest_time']))
                                {{ \Carbon\Carbon::parse($student['latest_time'])->diffForHumans() }}
                            @else
                                Belum menjawab
                            @endif
                        </div>
                        <div class="w-20 {{ $heights[$rankIndex] ?? 'h-28' }} {{ $colors[$rankIndex] ?? 'bg-indigo-400' }} rounded-t-md shadow-md flex items-end justify-center text-white font-bold text-xl mt-2">
                            {{ $emojis[$rankIndex] ?? '' }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Leaderboard Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto relative z-10">
            <table class="w-full text-xs sm:text-sm text-left border border-indigo-300 border-collapse min-w-[600px]">
                <thead class="bg-indigo-100 text-indigo-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-3 border border-indigo-200 text-center w-14">Rank</th>
                        <th class="px-4 py-3 border border-indigo-200 text-left">Player</th>
                        <th class="px-4 py-3 border border-indigo-200 text-center w-24">Total Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $i => $student)
                        @if ($i >= 3)
                            @php
                                $avatarPath = $student['avatar_path'] ?? '';
                                $avatarUrl = (!$avatarPath || in_array($avatarPath, ['default.png', 'special.jpg']))
                                    ? asset('storage/avatars/special.jpg')
                                    : asset('storage/' . $avatarPath);

                                $borderClass = match(true) {
                                    $i == 3 => 'border-yellow-300',
                                    $i == 4 => 'border-pink-300',
                                    default => 'border-indigo-300'
                                };
                            @endphp

                            <tr class="hover:bg-gray-50">
                                <!-- Rank -->
                                <td class="px-4 py-3 border border-indigo-100 text-center">{{ $i + 1 }}</td>

                                <!-- Player -->
                                <td class="px-4 py-3 border border-indigo-100">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full border-2 {{ $borderClass }} object-cover">
                                        <div class="text-left">
                                            <div class="font-medium text-gray-800 flex items-center gap-1 flex-wrap">
                                                {{ $student['name'] }}
                                                @if ($i + 1 == 1)
                                                    <span class="text-yellow-500 text-xs ml-1">🏆 Rank 1</span>
                                                @elseif ($i + 1 == 2)
                                                    <span class="text-gray-500 text-xs ml-1">🥈 Rank 2</span>
                                                @elseif ($i + 1 == 3)
                                                    <span class="text-amber-500 text-xs ml-1">🥉 Rank 3</span>
                                                @elseif ($i + 1 <= 10)
                                                    <span class="bg-indigo-100 text-indigo-600 text-[10px] px-2 py-[1px] rounded-full font-bold ml-1">Top 10</span>
                                                @endif
                                            </div>
                                            <div class="text-[10px] text-gray-400">
                                                @if (!empty($student['latest_time']))
                                                    {{ \Carbon\Carbon::parse($student['latest_time'])->diffForHumans() }}
                                                @else
                                                    Belum menjawab
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Score -->
                                <td class="px-4 py-3 border border-indigo-100 text-center font-semibold text-indigo-700">
                                    {{ $student['score'] }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
