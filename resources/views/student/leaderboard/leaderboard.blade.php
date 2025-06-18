@extends('student.layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-yellow-500 drop-shadow">🏆 Leaderboard</h1>
            <p class="text-gray-600 mt-2">Story: <strong>{{ $story->title }}</strong></p>
        </div>

        {{-- Podium Top 3 --}}
        <div class="flex justify-center items-end gap-6 mb-12">
            @php
                $podium = [1 => 'bg-gray-300', 0 => 'bg-yellow-400', 2 => 'bg-amber-400'];
                $heights = [1 => 'h-32', 0 => 'h-48', 2 => 'h-28'];
                $medals = [1 => '🥈', 0 => '🥇', 2 => '🥉'];
            @endphp

            @foreach ([1, 0, 2] as $i) {{-- Urut podium: 2 - 1 - 3 --}}
                @if (isset($students[$i]))
                    <div class="flex flex-col items-center">
                        <div class="text-3xl">{{ $medals[$i] }}</div>
                        <img src="{{ asset('storage/' . $students[$i]['avatar_path']) }}"
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
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-500 font-semibold">{{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <img src="{{ asset('storage/' . $student['avatar_path']) }}"
                                        class="w-12 h-12 rounded-full object-cover shadow-lg ring-2 ring-indigo-300 hover:scale-110 transition-transform duration-300">

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

        <div class="mt-8 text-center">

            <a href="{{ route('student.leaderboard.global') }}"
                class="inline-block mb-4 text-sm text-indigo-600 hover:underline">
                🔙 Lihat ke Global Leaderboard
            </a>

        </div>


    </div>
@endsection