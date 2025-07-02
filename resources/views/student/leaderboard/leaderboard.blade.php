@extends('student.layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8 relative">

        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-yellow-500 drop-shadow">🏆 Leaderboard</h1>
            <p class="text-gray-600 mt-2">Story: <strong>{{ $story->title }}</strong></p>
        </div>

        <a href="{{ route('student.leaderboard.global') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg transition duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Global Leaderboard
        </a>

        {{-- Podium Top 3 --}}
        <div class="flex justify-center items-end gap-6 mb-12">
            @php
                $podium = [1 => 'bg-gray-300', 0 => 'bg-yellow-400', 2 => 'bg-amber-400'];
                $heights = [1 => 'h-32', 0 => 'h-48', 2 => 'h-28'];
                $medals = [1 => '🥈', 0 => '🥇', 2 => '🥉'];
            @endphp

            @foreach ([1, 0, 2] as $i)
                @if (isset($students[$i]))
                    @php
                        $avatarPath = $students[$i]['avatar_path'] ?? '';
                        // Kalau avatar kosong atau default, pakai special.jpg
                        if (!$avatarPath || in_array($avatarPath, ['default.png', 'special.jpg'])) {
                            $avatarUrl = asset('storage/avatars/special.jpg');
                        } else {
                            $avatarUrl = asset('storage/' . $avatarPath);
                        }
                    @endphp

                    <div class="flex flex-col items-center">
                        <div class="text-3xl">{{ $medals[$i] }}</div>
                        <img src="{{ $avatarUrl }}"
                            class="w-16 h-16 rounded-full border-4 border-white shadow mb-2 object-cover">
                        <div
                            class="{{ $podium[$i] }} {{ $heights[$i] }} w-20 rounded-t-xl flex items-end justify-center text-white font-bold text-lg shadow-lg">
                            {{ $students[$i]['score'] }}
                        </div>
                        <div class="mt-2 text-sm text-center font-semibold text-gray-700">{{ $students[$i]['name'] }}</div>
                        <div class="text-xs text-gray-500">{{ $students[$i]['class'] }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        {{-- Tabel untuk ranking lainnya --}}
        <div class="bg-white rounded-xl shadow overflow-hidden overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Avatar</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kelas</th>
                        <th class="px-6 py-3 text-right text-sm font-semibold text-gray-700">Total Skor</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($students as $index => $student)
                        @if ($index > 2)
                            @php
                                $avatarPath = $student['avatar_path'] ?? '';
                                if (!$avatarPath || in_array($avatarPath, ['default.png', 'special.jpg'])) {
                                    $avatarUrl = asset('storage/avatars/special.jpg');
                                } else {
                                    $avatarUrl = asset('storage/' . $avatarPath);
                                }
                            @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 font-semibold">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ $avatarUrl }}" class="w-10 h-10 rounded-full border-2 border-indigo-300 object-cover">
                                </td>
                                <td class="px-6 py-4 text-sm">{{ $student['name'] }}</td>
                                <td class="px-6 py-4 text-sm">{{ $student['class'] }}</td>
                                <td class="px-6 py-4 text-sm text-right">{{ $student['score'] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
