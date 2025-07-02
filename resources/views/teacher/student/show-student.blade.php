@extends('teacher.layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h2 class="text-3xl font-bold text-purple-700 mb-6">📋 Student List</h2>

    <div class="overflow-x-auto bg-white rounded-2xl shadow-lg">
        <table class="min-w-full text-sm text-left table-auto">
            <thead class="bg-purple-700 text-white uppercase text-xs sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Class</th>
                    <th class="px-6 py-4">Total Score</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-gray-700">
                @forelse ($students as $student)
                    <tr class="hover:bg-purple-50 transition">
                        <td class="px-6 py-4">{{ $student->id }}</td>
                        <td class="px-6 py-4 font-semibold">{{ $student->user->name ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $student->class }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block bg-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                                {{ $student->total_score }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-400 italic">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
