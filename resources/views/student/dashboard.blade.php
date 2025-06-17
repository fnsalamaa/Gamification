@extends('student.layouts.app')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row items-center justify-between gap-6">

            {{-- Kiri: Info Siswa --}}
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-purple-700 mb-2">Halo, {{ $student->user->name }}!</h2>
                <p class="text-gray-600">Selamat datang di dashboard kamu. Semangat belajar dan selesaikan cerita menarik!
                </p>

                {{-- Optional: Tambah skor --}}
                <div class="mt-4">
                    <div class="bg-purple-100 text-purple-800 inline-block px-4 py-2 rounded-full text-sm font-semibold">
                        Total Skor: {{ $student->total_score }} | Mingguan: {{ $student->weekly_score }}
                    </div>
                </div>
            </div>

            {{-- Kanan: Avatar --}}
            {{-- Avatar Section di Dashboard --}}
            @if ($selectedAvatar)
                <div class="text-center">
                    <h5 class="text-gray-600 mb-2 font-medium">Avatar Kamu</h5>
                    <div class="relative inline-block">
                        <img onclick="openModal()" src="{{ asset('storage/' . $selectedAvatar->image_path) }}"
                            alt="Avatar"
                            class="w-28 h-28 rounded-full border-4 border-purple-300 shadow-lg transition hover:scale-105 cursor-pointer">
                    </div>
                    <p class="mt-2 font-semibold text-lg text-purple-800">{{ $selectedAvatar->name }}</p>
                </div>
            @endif




        </div>

        {{-- Modal Edit Profil --}}
        <div id="editProfileModal"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
            <div class="bg-white rounded-xl p-6 w-full max-w-lg relative">
                {{-- Tombol Close --}}
                <button onclick="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-red-600 text-2xl">&times;</button>

                <h2 class="text-xl font-bold mb-4 text-purple-700">Edit Profil</h2>

                <form method="POST" action="{{ route('student.profile.update') }}">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                            class="w-full p-2 border rounded-lg" required>
                    </div>

                    {{-- Kelas --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Kelas</label>
                        <input type="text" name="class" value="{{ old('class', $student->class) }}"
                            class="w-full p-2 border rounded-lg" required>
                    </div>

                    {{-- Pilih Avatar --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Pilih Avatar</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach ($student->avatars->where('pivot.is_unlocked', true) as $avatar)
                                <label class="cursor-pointer">
                                    <input type="radio" name="avatar_id" value="{{ $avatar->id }}"
                                        {{ $avatar->pivot->is_selected ? 'checked' : '' }}>
                                    <img src="{{ asset('storage/' . $avatar->image_path) }}"
                                        class="w-16 h-16 rounded-full border-2 border-purple-400 hover:scale-105 transition">
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>


        {{-- Tambahan konten dashboard lain di bawah --}}
        <div class="mt-8">
            {{-- Misalnya progress, notifikasi, dll --}}
        </div>

        {{-- Tambahan navigasi card --}}
        <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Card: Choose Story --}}
            <a href="{{ route('student.story.chooseStory') }}"
                class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">

                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-white text-purple-600 p-3 rounded-full shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path
                                d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                        </svg>

                    </div>
                    <div>
                        <h4 class="text-xl font-bold">Choose Your Story</h4>
                        <p class="text-sm text-white/90">Begin your exciting folklore adventure!</p>
                    </div>
                </div>

                {{-- Cerita yang Ditampilkan --}}
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6 mt-4">
                    @foreach ($stories as $story)
                        <div class="text-center">
                            <button onclick="showStoryDetail(`{{ e($story->title) }}`, `{{ e($story->description) }}`)"
                                class="bg-white aspect-square w-full rounded-xl shadow-md hover:scale-105 transition duration-300 overflow-hidden flex flex-col justify-center items-center">
                                <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}"
                                    class="w-full h-full object-cover">
                            </button>
                            <p class="text-sm text-white mt-2 font-semibold truncate">{{ $story->title }}</p>

                        </div>
                    @endforeach
                </div>
            </a>


            {{-- Section: Card + Badge --}}
            <div
                class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-4 mb-4">
                    <div class="bg-white text-yellow-600 p-3 rounded-full shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd"
                                d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>
                    <div>
                        <h4 class="text-2xl font-bold">Badge</h4>
                        <p class="text-sm text-white/90">Tap a badge to see what you've unlocked!</p>
                    </div>
                </div>

                {{-- Badges (icon only) --}}
                <div class="flex flex-wrap gap-3 mt-2">
                    @foreach ($ownedBadges as $badge)
                        <button onclick="showBadgeDetail('{{ $badge->name }}', '{{ $badge->description }}')"
                            class="bg-white p-2 rounded-full shadow-md hover:scale-110 transition duration-300">
                            <img src="{{ asset('storage/' . $badge->icon) }}" alt="{{ $badge->name }}"
                                class="w-10 h-10 object-cover rounded-full">
                        </button>
                    @endforeach
                </div>

            </div>

            {{-- Modal untuk detail badge --}}
            <div id="badgeModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-xl shadow-lg max-w-xs text-center relative">
                    <button onclick="closeBadgeModal()"
                        class="absolute top-2 right-3 text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    <h3 id="modalBadgeName" class="text-xl font-bold mb-2 text-purple-700"></h3>
                    <p id="modalBadgeDesc" class="text-sm text-gray-600"></p>
                </div>
            </div>

            {{-- Card: Leaderboard --}}
            <a href=""
                class="bg-gradient-to-r from-green-400 to-green-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition duration-300">
                <div class="flex items-center gap-4">
                    <div class="bg-white text-green-600 p-3 rounded-full shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path
                                d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75ZM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 0 1-1.875-1.875V8.625ZM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 0 1 3 19.875v-6.75Z" />
                        </svg>

                    </div>
                    <div>
                        <h4 class="text-xl font-bold">Leaderboard</h4>
                        <p class="text-sm">Climb to the top and beat your friends!</p>
                    </div>
                </div>
            </a>
        </div>

    </div>
@endsection

<script>
    function showBadgeDetail(name, description) {
        document.getElementById('modalBadgeName').innerText = name;
        document.getElementById('modalBadgeDesc').innerText = description;
        document.getElementById('badgeModal').classList.remove('hidden');
    }

    function closeBadgeModal() {
        document.getElementById('badgeModal').classList.add('hidden');
    }

    function openModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }
</script>
