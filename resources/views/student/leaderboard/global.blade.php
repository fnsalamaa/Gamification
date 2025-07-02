@extends('student.layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-6 relative">
        <!-- Optional background -->
        <div
            class="absolute inset-0 opacity-10 bg-[url('/images/bg-leaderboard.png')] bg-cover bg-center pointer-events-none">
        </div>

        <h1 class="text-3xl font-extrabold mb-6 text-center text-indigo-700 relative z-10">🏆 Global Leaderboard</h1>

        <!-- Judul & Filter -->
        <div class="relative z-10 flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <label class="text-sm font-semibold text-indigo-800 flex items-center">
                    <span class="mr-2">📖 Choose Story:</span>
                </label>
                <div class="relative">
                    <select
                        onchange="if(this.value) window.location.href = '{{ url('student/leaderboard') }}/' + this.value"
                        class="appearance-none bg-gradient-to-r from-purple-200 via-indigo-200 to-blue-200 text-indigo-900 font-semibold py-2 pl-4 pr-10 rounded-full border-2 border-indigo-300 shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-400 text-sm transition-all duration-300">
                        <option value="">🌍 All Story</option>
                        @foreach ($allStories as $s)
                            <option value="{{ $s->id }}">{{ $s->title }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-indigo-600">
                        ▼
                    </div>
                </div>
            </div>
        </div>

        {{-- Podium Section --}}
        @php
            $topThree = $students->take(3);
            $colors = ['bg-yellow-400', 'bg-gray-400', 'bg-amber-500'];
            $heights = ['h-40', 'h-32', 'h-28'];
            $emojis = ['🥇', '🥈', '🥉'];
            $visualOrder = [1, 0, 2];
        @endphp

        <div class="relative z-10 flex justify-center items-end gap-6 mb-10">
            @foreach ($visualOrder as $rankIndex)
                @php
                    $student = $topThree[$rankIndex] ?? null;
                @endphp

                @if ($student)
                    @php
                        $avatarPath = $student['avatar_path'] ?? '';

                        // Kalau avatar kosong, default.png, atau special.jpg, pakai special.jpg
                        if (!$avatarPath || in_array($avatarPath, ['default.png', 'special.jpg'])) {
                            $avatarUrl = asset('storage/avatars/special.jpg');
                        } else {
                            $avatarUrl = asset('storage/' . $avatarPath);
                        }
                    @endphp

                    <div class="flex flex-col items-center">
                        <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full border-2 border-indigo-300 object-cover">
                        <div class="mt-2 text-sm font-semibold text-gray-800 text-center">
                            {{ $student['name'] }}
                        </div>
                        <div class="text-xs text-gray-500 mb-2">Score: {{ $student['score'] }}</div>
                        <div
                            class="w-20 {{ $heights[$rankIndex] ?? 'h-28' }} {{ $colors[$rankIndex] ?? 'bg-indigo-400' }} rounded-t-md shadow-md flex items-end justify-center text-white font-bold text-xl">
                            {{ $emojis[$rankIndex] ?? '' }}
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Tabel Leaderboard Lainnya --}}
        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative z-10">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-indigo-100 text-indigo-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Rank</th>
                            <th class="px-4 py-3 text-left">Player</th>
                            <th class="px-4 py-3 text-right">Total Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $i => $student)
                            @if ($i >= 3)
                                @php
                                    $avatarPath = $student['avatar_path'] ?? '';

                                    if (!$avatarPath || in_array($avatarPath, ['default.png', 'special.jpg'])) {
                                        $avatarUrl = asset('storage/avatars/special.jpg');
                                    } else {
                                        $avatarUrl = asset('storage/' . $avatarPath);
                                    }
                                @endphp

                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">{{ $i + 1 }}</td>
                                    <td class="px-4 py-3 flex items-center space-x-3">
                                        <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full border-2 border-indigo-300 object-cover">
                                        <div>
                                            <div class="font-medium text-gray-800">
                                                {{ $student['name'] }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right font-semibold text-indigo-700">
                                        {{ $student['score'] }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
