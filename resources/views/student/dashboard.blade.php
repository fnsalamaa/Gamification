@extends('student.layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row items-center justify-between gap-6">

        {{-- Kiri: Info Siswa --}}
        <div class="flex-1">
            <h2 class="text-3xl font-bold text-purple-700 mb-2">Halo, {{ $student->user->name }}!</h2>
            <p class="text-gray-600">Selamat datang di dashboard kamu. Semangat belajar dan selesaikan cerita menarik!</p>

            {{-- Optional: Tambah skor --}}
            <div class="mt-4">
                <div class="bg-purple-100 text-purple-800 inline-block px-4 py-2 rounded-full text-sm font-semibold">
                    Total Skor: {{ $student->total_score }} | Mingguan: {{ $student->weekly_score }}
                </div>
            </div>
        </div>

        {{-- Kanan: Avatar --}}
        @if ($selectedAvatar)
        <div class="text-center">
            <h5 class="text-gray-600 mb-2 font-medium">Avatar Kamu</h5>
            <div class="relative inline-block">
                <img src="{{ asset('storage/' . $selectedAvatar->image_path) }}" alt="Avatar"
                    class="w-28 h-28 rounded-full border-4 border-purple-300 shadow-lg transition hover:scale-105">
            </div>
            <p class="mt-2 font-semibold text-lg text-purple-800">{{ $selectedAvatar->name }}</p>
        </div>
        @endif

    </div>

    {{-- Tambahan konten dashboard lain di bawah --}}
    <div class="mt-8">
        {{-- Misalnya progress, notifikasi, dll --}}
    </div>

    {{-- Tambahan navigasi card --}}
<div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- Card: Choose Story --}}
    <a href="{{ route('student.story.chooseStory') }}" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
        <div class="flex items-center gap-4">
            <div class="bg-white text-purple-600 p-3 rounded-full shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div>
                <h4 class="text-xl font-bold">Pilih Cerita</h4>
                <p class="text-sm">Mulai petualangan folklore-mu!</p>
            </div>
        </div>
    </a>

    {{-- Card: Badges --}}
    <a href="" class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
        <div class="flex items-center gap-4">
            <div class="bg-white text-yellow-600 p-3 rounded-full shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <h4 class="text-xl font-bold">Lencana</h4>
                <p class="text-sm">Lihat pencapaianmu.</p>
            </div>
        </div>
    </a>

    {{-- Card: Leaderboard --}}
    <a href="" class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
        <div class="flex items-center gap-4">
            <div class="bg-white text-green-600 p-3 rounded-full shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10h2l1 9h12l1-9h2"/>
                </svg>
            </div>
            <div>
                <h4 class="text-xl font-bold">Peringkat</h4>
                <p class="text-sm">Lihat posisi kamu!</p>
            </div>
        </div>
    </a>
</div>

</div>
@endsection
