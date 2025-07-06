@extends('student.layouts.app')

@section('content')
@if(session('success'))
    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        {{ session('error') }}
    </div>
@endif

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-extrabold mb-8 text-center text-purple-700">🧙 Choose Your Avatar</h1>

    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @foreach ($avatars as $avatar)
            <form action="{{ route('student.avatar.select', $avatar->id) }}" method="POST" class="group">
                @csrf
                <div class="relative border-4 p-4 rounded-2xl bg-gradient-to-br from-purple-100 to-indigo-100 shadow-lg 
                    transition-transform transform group-hover:scale-105 min-h-[360px] flex flex-col justify-between
                    @if($avatar->is_selected) border-green-500 @else border-transparent @endif">

                    {{-- Selected check icon --}}
                    @if($avatar->is_selected)
                        <div class="absolute top-2 right-2 bg-green-500 text-white rounded-full p-1 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    @endif

                    {{-- Locked icon --}}
                    @if(!$avatar->is_unlocked)
                        <div class="absolute top-2 left-2 bg-gray-700 text-white rounded-full p-1 shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 11c0-1.105-.895-2-2-2s-2 .895-2 2v1h4v-1zm0 0V9a4 4 0 10-8 0v2m8 0h4a2 2 0 012 2v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3a2 2 0 012-2h4z" />
                            </svg>
                        </div>
                    @endif

                    {{-- Avatar image --}}
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $avatar->image_path) }}"
                             class="w-24 h-24 rounded-full border-4 border-purple-300 shadow-md object-cover
                             {{ !$avatar->is_unlocked ? 'grayscale opacity-60' : '' }}">
                    </div>

                    {{-- Avatar name and description --}}
                    <div class="mt-4 text-center px-1">
                        <h2 class="text-base sm:text-lg font-bold text-gray-800">{{ $avatar->name }}</h2>
                        <p class="text-sm text-gray-600 mt-1 leading-snug">{{ $avatar->description }}</p>
                    </div>

                    {{-- Select button --}}
                    <div class="mt-4">
                        <button type="submit"
                                class="w-full text-sm font-semibold py-2 rounded-lg transition-all duration-300
                                {{ $avatar->is_unlocked 
                                    ? 'bg-gradient-to-r from-purple-600 to-indigo-600 text-white hover:from-purple-700 hover:to-indigo-700' 
                                    : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}"
                                {{ !$avatar->is_unlocked ? 'disabled' : '' }}>
                            {{ $avatar->is_unlocked ? 'Select' : 'Locked' }}
                        </button>
                    </div>
                </div>
            </form>
        @endforeach
    </div>
</div>
@endsection
