@extends('teacher.layouts.app')

@section('content')
<div class="max-w-screen-xl mx-auto mt-10 px-4">
    <h2 class="text-center text-3xl font-bold text-yellow-800 mb-6">📚 Story List</h2>

    <div class="overflow-x-auto">
        <div class="min-w-full inline-block align-middle bg-white rounded-2xl shadow ring-1 ring-gray-200">
            <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                <thead class="bg-yellow-100 text-yellow-800 uppercase text-xs font-bold sticky top-0 z-10">
                    <tr>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Cover</th>
                        <th class="px-6 py-4">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 divide-y divide-gray-100 bg-white">
                    @forelse ($stories as $story)
                        <tr class="hover:bg-yellow-50 transition">
                            <td class="px-6 py-4 font-semibold align-middle">{{ $story->title }}</td>
                            <td class="px-6 py-4 align-middle">
                                <img src="{{ asset('storage/' . $story->cover) }}" alt="cover"
                                     class="w-28 h-auto mx-auto rounded-xl border shadow-md">
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <a href="{{ route('teacher.story.detail', $story->id) }}"
                                   class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow transition">
                                    View Questions
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-gray-400 italic text-center">
                                No stories available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
