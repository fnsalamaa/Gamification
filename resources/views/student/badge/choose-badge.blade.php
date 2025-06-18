@extends('student.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-4xl font-extrabold mb-8 text-center text-purple-700 drop-shadow">🎖️ Your Badges</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach ($allBadges as $badge)
            <div class="relative group rounded-3xl overflow-hidden shadow-lg transform hover:scale-105 transition-all duration-300
                @if(in_array($badge->id, $ownedBadges))
                    border-4 border-yellow-400 bg-gradient-to-br from-white to-yellow-50
                @else
                    border-2 border-gray-200 bg-gray-50
                @endif">

                {{-- Icon: Check (unlocked) --}}
                @if(in_array($badge->id, $ownedBadges))
                    <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full p-1 shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                @endif

                {{-- Icon: Lock (locked) --}}
                @if(!in_array($badge->id, $ownedBadges))
                    <div class="absolute top-2 left-2 bg-gray-600 text-white rounded-full p-1 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2v1h4v-1zm0 0V9a4 4 0 10-8 0v2m8 0h4a2 2 0 012 2v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3a2 2 0 012-2h4z" />
                        </svg>
                    </div>
                @endif

                {{-- Badge Icon --}}
                <div class="flex justify-center mt-6">
                    <img src="{{ asset('storage/' . $badge->icon) }}"
                        class="w-24 h-24 rounded-full border-4
                        @if(in_array($badge->id, $ownedBadges))
                            border-yellow-400 shadow-yellow-300 shadow-md
                        @else
                            border-gray-300 grayscale opacity-50
                        @endif"
                    >
                </div>

                <div class="px-4 py-4 text-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $badge->name }}</h3>
                    <p class="text-sm text-gray-500 mb-3">{{ $badge->description }}</p>
                    <p class="text-sm font-semibold
                        @if(in_array($badge->id, $ownedBadges))
                            text-green-600
                        @else
                            text-gray-400 italic
                        @endif">
                        {{ in_array($badge->id, $ownedBadges) ? '✔ Unlocked' : '🔒 Locked' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
