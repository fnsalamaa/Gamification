@extends('teacher.layouts.app')

@section('content')
    <div class="max-w-screen-xl mx-auto mt-10 px-4">
        <h2 class=" text-center text-3xl font-bold text-yellow-800 mb-6">📋 Student List</h2>

        <div class="overflow-x-auto">
            <div
                class="max-h-[500px] overflow-y-auto min-w-full inline-block align-middle bg-white rounded-2xl shadow ring-1 ring-gray-200">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-center">
                    <thead class="bg-yellow-100 text-yellow-800 uppercase text-xs font-bold sticky top-0 z-10">
                        <tr>
                            <th class="px-6 py-4 whitespace-nowrap">ID</th>
                            <th class="px-6 py-4 whitespace-nowrap">Name</th>
                            <th class="px-6 py-4 whitespace-nowrap">Class</th>
                            <th class="px-6 py-4 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700 bg-white">
                        @forelse ($students as $student)
                            <tr class="hover:bg-yellow-50 transition">
                                <td class="px-6 py-4 align-middle whitespace-nowrap">{{ $student->id }}</td>
                                <td class="px-6 py-4 align-middle font-semibold whitespace-nowrap">
                                    {{ $student->user->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 align-middle whitespace-nowrap">{{ $student->class }}</td>
                                <td class="px-6 py-4 align-middle">
                                    <a href="{{ route('teacher.student-progress.detail', $student->id) }}"
                                        class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow transition">
                                        📊 View Progress
                                    </a>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center text-gray-400 italic">No students found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-end">
                <div class="inline-flex items-center space-x-2 text-sm text-gray-600">
                    {{ $students->links('pagination::tailwind') }}
                </div>
            </div>


        </div>
    </div>
@endsection