
@extends('admin.layouts.app')


@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <!-- Total Users Card -->
    <a href="{{ route('admin.users.show-users') }}"
       class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center hover:bg-pink-50 transition duration-200 group">
        <div>
            <h3 class="text-lg font-semibold text-gray-700 group-hover:text-pink-600 transition">Total Users</h3>
            <p class="text-3xl font-bold text-pink-600 mt-2">{{ $totalUsers }}</p>
        </div>
        <div class="text-pink-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                class="w-10 h-10 group-hover:scale-105 transition">
                <path fill-rule="evenodd"
                    d="M8.25 6.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM15.75 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM2.25 9.75a3 3 0 1 1 6 0 3 3 0 0 1-6 0ZM6.31 15.117A6.745 6.745 0 0 1 12 12a6.745 6.745 0 0 1 6.709 7.498.75.75 0 0 1-.372.568A12.696 12.696 0 0 1 12 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 0 1-.372-.568 6.787 6.787 0 0 1 1.019-4.38Z"
                    clip-rule="evenodd" />
                <path
                    d="M5.082 14.254a8.287 8.287 0 0 0-1.308 5.135 9.687 9.687 0 0 1-1.764-.44l-.115-.04a.563.563 0 0 1-.373-.487l-.01-.121a3.75 3.75 0 0 1 3.57-4.047ZM20.226 19.389a8.287 8.287 0 0 0-1.308-5.135 3.75 3.75 0 0 1 3.57 4.047l-.01.121a.563.563 0 0 1-.373.486l-.115.04c-.567.2-1.156.349-1.764.441Z" />
            </svg>
        </div>
    </a>

    <!-- Total Stories Card -->
    <a href="{{ route('admin.create-story') }}"
       class="bg-white shadow-md rounded-lg p-6 flex justify-between items-center hover:bg-yellow-50 transition duration-200 group">
        <div>
            <h3 class="text-lg font-semibold text-gray-700 group-hover:text-yellow-500 transition">Total Stories</h3>
            <p class="text-3xl font-bold text-yellow-500 mt-2">{{ $totalStories }}</p>
        </div>
        <div class="text-yellow-500">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                class="w-10 h-10 group-hover:scale-105 transition">
                <path
                    d="M11.25 4.533A9.707 9.707 0 0 0 6 3a9.735 9.735 0 0 0-3.25.555.75.75 0 0 0-.5.707v14.25a.75.75 0 0 0 1 .707A8.237 8.237 0 0 1 6 18.75c1.995 0 3.823.707 5.25 1.886V4.533ZM12.75 20.636A8.214 8.214 0 0 1 18 18.75c.966 0 1.89.166 2.75.47a.75.75 0 0 0 1-.708V4.262a.75.75 0 0 0-.5-.707A9.735 9.735 0 0 0 18 3a9.707 9.707 0 0 0-5.25 1.533v16.103Z" />
            </svg>
        </div>
    </a>
</div>

</div>

@endsection
