@extends('student.layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h2
            class="text-3xl font-extrabold mb-8 text-center text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-purple-500 animate-pulse flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-500 animate-bounce" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                
            </svg>
            Select the Verse
        </h2>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($stories as $story)
                <div
                    class="bg-white rounded-2xl shadow-md overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-xl">
                    <a href="{{ route('student.story.readStory', $story->id) }}">
                        <img src="{{ asset('storage/' . $story->cover) }}" alt="{{ $story->title }}"
                            class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 hover:text-red-500 transition duration-300">
                                {{ $story->title }}
                            </h3>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection