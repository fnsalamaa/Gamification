@extends('admin.layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <h1 class="text-3xl font-extrabold text-indigo-700 mb-8 text-center tracking-wide">
        🎮 Admin Dashboard
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Total Users Card -->
        <a href="{{ route('admin.users.show-users') }}"
            class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-all duration-300 group border-t-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-purple-600">
                        👥 Total Users
                    </h3>
                    <p class="text-4xl font-extrabold text-purple-500 mt-2">{{ $totalUsers }}</p>
                </div>
                <div class="text-purple-500 group-hover:scale-110 transform transition">
                    <svg class="w-12 h-12 text-purple-500 group-hover:text-purple-600"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Total Stories Card -->
        <a href="{{ route('admin.create-story') }}"
            class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-all duration-300 group border-t-4 border-amber-400">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-amber-500">
                        📚 Total Stories
                    </h3>
                    <p class="text-4xl font-extrabold text-amber-400 mt-2">{{ $totalStories }}</p>
                </div>
                <div class="text-amber-400 group-hover:scale-110 transform transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="w-12 h-12">
                        <path
                            d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
                    </svg>
                </div>
            </div>
        </a>

        <!-- Total Questions Card -->
        <a href="{{ route('admin.create-story') }}"
            class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition-all duration-300 group border-t-4 border-sky-400">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 group-hover:text-sky-500">
                        ❓ Total Questions
                    </h3>
                    <p class="text-4xl font-extrabold text-sky-400 mt-2">{{ $totalQuestions }}</p>
                </div>
                <div class="text-sky-400 group-hover:scale-110 transform transition">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.008-3.018a1.502 1.502 0 0 1 2.522 1.159v.024a1.44 1.44 0 0 1-1.493 1.418 1 1 0 0 0-1.037.999V14a1 1 0 1 0 2 0v-.539a3.44 3.44 0 0 0 2.529-3.256 3.502 3.502 0 0 0-7-.255 1 1 0 0 0 2 .076c.014-.398.187-.774.48-1.044Zm.982 7.026a1 1 0 1 0 0 2H12a1 1 0 1 0 0-2h-.01Z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </a>

    </div>
</div>
@endsection
