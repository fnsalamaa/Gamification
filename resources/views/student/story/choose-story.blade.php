@extends('student.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2
            class="text-3xl font-extrabold mb-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 via-pink-500 to-purple-600 animate-pulse flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-500 animate-bounce" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Select Your Adventure!
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach ($stories as $story)
                <a href="{{ route('student.story.readStory', $story->id) }}"
                    class="group relative block bg-gradient-to-br from-purple-200 via-pink-100 to-yellow-100 rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden hover:scale-105">

                    <!-- Cover -->
                    <div class="relative">
                        <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}"
                            class="w-full h-48 object-cover rounded-t-3xl">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-10 transition duration-300"></div>
                    </div>

                    <!-- Info -->
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-600 transition duration-300">
                            {{ $story->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 italic">Click to Begin</p>
                    </div>

                    <!-- Badge icon (optional) -->
                    <div class="absolute top-3 right-3 bg-pink-500 text-white text-xs px-3 py-1 rounded-full shadow">
                        🎮 Story
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
