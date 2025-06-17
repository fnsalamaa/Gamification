@extends('teacher.layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h2 class="text-3xl font-bold text-purple-700 mb-6">Story List</h2>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-lg rounded-lg">
            <thead class="bg-purple-100 text-purple-800 uppercase text-sm font-semibold">
                <tr>
                    <th class="py-4 px-6 text-left">Title</th>
                    <th class="py-4 px-6 text-left">Cover</th>
                    <th class="py-4 px-6 text-left">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse ($stories as $story)
                    <tr class="border-b hover:bg-gray-50 transition duration-200">
                        <td class="py-4 px-6 font-medium">{{ $story->title }}</td>
                        <td class="py-4 px-6">
                            <img src="{{ asset('storage/' . $story->cover) }}" class="w-28 h-auto rounded-xl shadow-md border" alt="cover">
                        </td>
                        <td class="py-4 px-6">
                            <a href="{{ route('teacher.story.detail', $story->id) }}"
                               class="inline-block bg-indigo-600 text-white text-sm px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition">
                                View Questions
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">No stories available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
