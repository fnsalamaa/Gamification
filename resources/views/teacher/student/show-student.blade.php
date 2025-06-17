@extends('teacher.layouts.app')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h2 class="text-3xl font-bold text-purple-700 mb-6">📋 Student List</h2>

    <div class="overflow-x-auto shadow-xl rounded-2xl bg-white">
        <table class="min-w-full table-auto text-sm text-left">
            <thead class="bg-purple-700 text-white uppercase text-xs sticky top-0 z-10">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Name</th>
                    <th class="px-6 py-4">Class</th>
                    <th class="px-6 py-4">Total Score</th>
                    <th class="px-6 py-4">Weekly Score</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y divide-gray-200">
                @foreach ($students as $student)
                <tr class="hover:bg-purple-50 transition">
                    <td class="px-6 py-4">{{ $student->id }}</td>
                    <td class="px-6 py-4 font-medium">{{ $student->user->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $student->class }}</td>
                    <td class="px-6 py-4">{{ $student->total_score }}</td>
                    <td class="px-6 py-4">{{ $student->weekly_score }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
