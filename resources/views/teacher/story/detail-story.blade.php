@extends('teacher.layouts.app')

@section('content')
    <div class="container mx-auto mt-8 px-4">

        {{-- Tombol kembali --}}
        <a href="{{ url('/teacher/story') }}"
            class="inline-block mb-6 bg-yellow-700 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-800 transition">
            ← Kembali
        </a>

        <h2 class="text-4xl font-extrabold text-yellow-800 mb-4 text-center drop-shadow-md tracking-wide">
            🎮 {{ $story->title }} 🎯
        </h2>

        <div class="flex justify-center mb-6">
            <div class="relative group transition-transform hover:scale-105 duration-300">

                <img src="{{ asset('storage/' . $story->cover) }}"
                    class="w-52 h-auto rounded-2xl border-4 border-yellow-800 shadow-lg group-hover:shadow-yellow-400 transition-shadow duration-300">
            </div>
        </div>


        {{-- Loop stage --}}
        @forelse ($story->stages as $stage)
            <div x-data="{ open: false }" class="mb-6 border border-yellow-300 rounded-xl shadow bg-yellow-50 overflow-hidden">
                <button @click="open = !open"
                    class="w-full text-left px-6 py-4 text-yellow-900 font-semibold flex justify-between items-center">
                    Stage {{ $stage->order }} - {{ ucfirst($stage->stage_type) }}
                    <svg :class="{ 'rotate-180': open }" class="w-5 h-5 transition-transform duration-300" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-collapse class="px-4 pb-4">
                    @if($stage->questions->count())
                        <div class="overflow-x-auto max-h-[500px] overflow-y-auto border rounded-xl mt-3 shadow-inner">
                            <table class="min-w-full bg-white text-center text-sm">
                                <thead class="bg-yellow-200 text-yellow-900 uppercase text-xs font-semibold sticky top-0 z-10">
                                    <tr>
                                        <th class="py-3 px-4">Narrative</th>
                                        <th class="py-3 px-4">Image</th>
                                        <th class="py-3 px-4">Question</th>
                                        <th class="py-3 px-4">Options</th>
                                        <th class="py-3 px-4">Answer</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 text-gray-700">
                                    @foreach ($stage->questions as $q)
                                        <tr class="hover:bg-yellow-50 transition">
                                            <td class="py-3 px-4">{{ $q->narrative }}</td>
                                            <td class="py-3 px-4">
                                                @if ($q->image)
                                                    <img src="{{ asset('storage/' . $q->image) }}"
                                                        class="w-32 h-auto rounded border shadow">

                                                @else
                                                    <span class="text-gray-400 italic">-</span>
                                                @endif
                                            </td>
                                            <td class="py-3 px-4">{{ $q->question_text }}</td>
                                            <td class="py-3 px-4">
                                                <ul class="list-disc text-left pl-4 space-y-1">
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
            </div>
        @empty
            <p class="text-gray-500">No stages found for this story.</p>
        @endforelse

    </div>
@endsection