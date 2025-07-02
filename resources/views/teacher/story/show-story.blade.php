@extends('teacher.layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h2 class="text-3xl font-bold text-purple-700 mb-6">📚 Story List</h2>

    <div class="overflow-x-auto bg-white shadow-xl rounded-2xl">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-purple-100 text-purple-800 uppercase text-xs font-bold">
                <tr>
                    <th class="px-6 py-4">Title</th>
                    <th class="px-6 py-4">Cover</th>
                    <th class="px-6 py-4">Action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-200">
                @forelse ($stories as $story)
                    <tr class="hover:bg-purple-50 transition">
                        <td class="px-6 py-4 font-semibold">{{ $story->title }}</td>
                        <td class="px-6 py-4">
                            <img src="{{ asset('storage/' . $story->cover) }}" alt="cover"
                                 class="w-28 h-auto rounded-xl border shadow">
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('teacher.story.detail', $story->id) }}"
                               class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm shadow hover:bg-indigo-700 transition">
                                View Questions
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center px-6 py-6 text-gray-400 italic">No stories available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
