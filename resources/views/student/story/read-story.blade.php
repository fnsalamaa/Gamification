@extends('student.layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">

        <div class="flex justify-center my-6">
            <button type="button" class="text-gray-900 text-xl bg-gradient-to-r from-red-200 via-red-300 to-yellow-200 hover:bg-gradient-to-bl
                           focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-400
                           font-medium rounded-lg px-8 py-4 text-center">
                {{ $story->title }}
            </button>
        </div>

        {{-- <form method="POST" action="{{ route('quiz.submit', $story->id) }}"> --}}
            @csrf

            <div x-data="{ currentStage: 0 }">
                @foreach ($stages as $i => $stage)
                    <div x-show="currentStage === {{ $i }}" x-transition class="mb-8">
                        <h2 class="text-xl font-semibold text-black mb-4 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-black rounded-full"></span>
                            Stage {{ $stage->order }} - {{ ucfirst($stage->stage_type) }}
                        </h2>

                        @foreach ($stage->questions as $index => $question)
                            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                                <h3 class="text-lg font-semibold mb-2">Story {{ $index + 1 }}</h3>

                                @if ($question->narrative)
                                    <p class="mb-3">{{ $question->narrative }}</p>
                                @endif

                                @if ($question->image)
                                    <div class="mb-3 flex justify-center">
                                        <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Soal"
                                            class="w-64 h-auto rounded border shadow-md">
                                    </div>
                                @endif

                                <p class="mb-3">Question: {{ $question->question_text }}</p>
                                <p class="mb-3">Answer:</p>

                                @php $questionId = $question->id; @endphp
                                <div class="space-y-3">
                                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                                        @php $optionValue = strtolower("option_$opt"); @endphp
                                        <label
                                            class="block border border-gray-300 rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 transition">

                                            <input type="radio" name="answers[{{ $questionId }}]" value="{{ $opt }}"
                                                class="hidden peer">

                                            <div
                                                class="peer-checked:bg-amber-500 peer-checked:text-white rounded-md transition duration-200 p-2">
                                                <p class="text-base">{{ $opt }}. {{ $question->$optionValue }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        {{-- Tombol Navigasi --}}
                        <div class="flex justify-between mt-6">
                            <button x-show="currentStage > 0" @click="currentStage--"
                                class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-2 rounded">
                                Sebelumnya
                            </button>

                            <template x-if="currentStage < {{ count($stages) - 1 }}">
                                <button @click="currentStage++"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded ml-auto">
                                    Selanjutnya
                                </button>
                            </template>

                            <template x-if="currentStage === {{ count($stages) - 1 }}">
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded ml-auto">
                                    Kumpulkan Jawaban
                                </button>
                            </template>
                        </div>
                    </div>
                @endforeach
            </div>

        {{-- </form> --}}
    </div>
@endsection