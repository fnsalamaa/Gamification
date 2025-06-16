@extends('student.layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-700">🎖️ Your Badges</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($allBadges as $badge)
            <div class="relative group border-2 p-4 rounded-2xl transition transform group-hover:scale-105 shadow-md hover:shadow-xl bg-white
                @if(in_array($badge->id, $ownedBadges)) border-green-500 @else border-gray-200 @endif">

                {{-- Icon check if owned --}}
                @if(in_array($badge->id, $ownedBadges))
                    <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full p-1 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                @endif

                {{-- Lock icon if not owned --}}
                @if(!in_array($badge->id, $ownedBadges))
                    <div class="absolute top-2 left-2 bg-gray-600 text-white rounded-full p-1 shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2v1h4v-1zm0 0V9a4 4 0 10-8 0v2m8 0h4a2 2 0 012 2v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3a2 2 0 012-2h4z" />
                        </svg>
                    </div>
                @endif

                {{-- Badge icon --}}
                <img src="{{ asset('storage/' . $badge->icon) }}"
                     class="w-24 h-24 mx-auto mb-3 rounded-full border border-gray-300 
                     {{ !in_array($badge->id, $ownedBadges) ? 'grayscale opacity-60' : '' }}">

                <h3 class="text-center font-semibold text-lg text-gray-800">{{ $badge->name }}</h3>
                <p class="text-sm text-gray-500 text-center mt-1">{{ $badge->description }}</p>

                <p class="mt-4 text-center font-medium text-sm
                    {{ in_array($badge->id, $ownedBadges) ? 'text-green-600' : 'text-gray-400 italic' }}">
                    {{ in_array($badge->id, $ownedBadges) ? '✔ Unlocked' : 'Locked' }}
                </p>
            </div>
        @endforeach
    </div>
</div>
@endsection
