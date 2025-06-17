@extends('teacher.layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4">
    <div class="bg-white rounded-2xl shadow-xl p-6">
        <h2 class="text-4xl font-bold text-indigo-700 mb-4">{{ $story->title }}</h2>
        <img src="{{ asset('storage/' . $story->cover) }}" class="w-48 h-auto mb-6 rounded-xl shadow-md border border-gray-200">

        @forelse ($story->stages as $stage)
            <div class="mb-10 border border-indigo-100 rounded-xl p-5 shadow-sm bg-gray-50">
                <h3 class="text-2xl font-semibold text-purple-800 mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm0 2c-1.333 0-4 .667-4 2v2h8v-2c0-1.333-2.667-2-4-2z"/>
                    </svg>
                    Stage {{ $stage->order }} - {{ ucfirst($stage->stage_type) }}
                </h3>

                @if($stage->questions->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg shadow-md">
                        <thead class="bg-indigo-100 text-indigo-800 uppercase text-xs font-semibold">
                            <tr>
                                <th class="py-3 px-4 text-left">Narrative</th>
                                <th class="py-3 px-4 text-left">Image</th>
                                <th class="py-3 px-4 text-left">Question</th>
                                <th class="py-3 px-4 text-left">Options</th>
                                <th class="py-3 px-4 text-left">Answer</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                            @foreach ($stage->questions as $q)
                                <tr class="hover:bg-indigo-50 transition">
                                    <td class="py-3 px-4">{{ $q->narrative }}</td>
                                    <td class="py-3 px-4">
                                        @if ($q->image)
                                            <img src="{{ asset('storage/' . $q->image) }}" class="w-16 h-16 object-cover rounded border">
                                        @else
                                            <span class="text-gray-400 italic">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $q->question_text }}</td>
                                    <td class="py-3 px-4">
                                        <ul class="list-disc pl-4 space-y-1">
                                            <li><strong>A:</strong> {{ $q->option_a }}</li>
                                            <li><strong>B:</strong> {{ $q->option_b }}</li>
                                            <li><strong>C:</strong> {{ $q->option_c }}</li>
                                            <li><strong>D:</strong> {{ $q->option_d }}</li>
                                        </ul>
                                    </td>
                                    <td class="py-3 px-4 font-bold text-green-600">
                                        {{ strtoupper($q->correct_answer) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p class="text-gray-500 italic mt-2">No questions available for this stage.</p>
                @endif
            </div>
        @empty
            <p class="text-gray-500">No stages found for this story.</p>
        @endforelse
    </div>
</div>
@endsection
