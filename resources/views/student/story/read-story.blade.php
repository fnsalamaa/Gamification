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

        <div x-data="quizApp()">
            <template x-for="(stage, i) in stages" :key="i">
                <div x-show="currentStage === i" x-transition class="mb-8">
                    <h2 class="text-xl font-semibold text-black mb-4 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 bg-black rounded-full"></span>
                        Stage <span x-text="stage.order"></span> - <span x-text="stage.stage_type"></span>
                    </h2>

                    <template x-for="(question, index) in stage.questions" :key="question.id">
                        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                            <h3 class="text-lg font-semibold mb-2">Story <span x-text="index + 1"></span></h3>
                            <template x-if="question.narrative">
                                <p class="mb-3" x-text="question.narrative"></p>
                            </template>

                            <template x-if="question.image">
                                <div class="mb-3 flex justify-center">
                                    <img :src="'/storage/' + question.image" alt="Gambar Soal"
                                        class="w-64 h-auto rounded border shadow-md">
                                </div>
                            </template>

                            <p class="mb-3">Question: <span x-text="question.question_text"></span></p>
                            <p class="mb-3">Answer:</p>

                            <div class="space-y-3">
                                <template x-for="opt in ['A', 'B', 'C', 'D']" :key="opt">
                                    <label
                                        class="block border border-gray-300 rounded-lg px-4 py-2 cursor-pointer hover:bg-gray-100 transition">
                                        <input type="radio" :name="'q' + question.id" :value="opt"
                                            x-model="question.selected" :disabled="question.answered" class="hidden peer">
                                        <div
                                            class="peer-checked:bg-amber-500 peer-checked:text-white rounded-md transition duration-200 p-2">
                                            <p class="text-base"
                                                x-text="opt + '. ' + question['option_' + opt.toLowerCase()]"></p>
                                        </div>
                                    </label>
                                </template>
                            </div>

                            <button @click="submitAnswer(question)" :disabled="question.answered"
                                class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded">
                                Submit Answer
                            </button>
                            <p x-show="question.answered" class="text-sm text-green-600 mt-2">
                                The answer is correct, it cannot be changed.
                            </p>


                            <div x-show="question.feedback" class="mt-2 text-sm" :class="question.feedbackColor"
                                x-text="question.feedback"></div>
                        </div>
                    </template>

                    <div class="flex justify-between mt-6">
                        <button x-show="currentStage > 0" @click="prevStage"
                            class="bg-gray-400 hover:bg-gray-500 text-white font-semibold px-6 py-2 rounded">
                            Sebelumnya
                        </button>

                        <template x-if="!isLastStage">
                            <button :disabled="!isStageComplete()" @click="nextStage"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded ml-auto">
                                Selanjutnya
                            </button>
                        </template>

                        <template x-if="currentStage === {{ count($stages) - 1 }}">
                            <a href="{{ route('student.quiz.result', $story->id) }}"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded ml-auto">
                                Kumpulkan Jawaban
                            </a>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script>
        function quizApp() {
            return {
                currentStage: 0,
                stages: @json($stages).map(stage => {
                    stage.questions = stage.questions.map(q => ({
                        ...q,
                        selected: null,
                        attempts: 0,
                        answered: false,
                        points: 0,
                        feedback: '',
                        feedbackColor: '',
                    }));
                    return stage;
                }),
                isLastStage() {
                    return this.currentStage === this.stages.length - 1;
                },
                isStageComplete() {
                    return this.stages[this.currentStage].questions.every(q => q.answered || q.attempts >= 3);
                },
                nextStage() {
                    if (this.currentStage < this.stages.length - 1) this.currentStage++;
                },
                prevStage() {
                    if (this.currentStage > 0) this.currentStage--;
                },
                submitAnswer(question) {
                    if (question.answered) return;
                    if (!question.attempts) question.attempts = 0;
                    question.attempts++;

                    const isCorrect = question.selected === question.correct_answer;

                    if (isCorrect) {
                        if (question.attempts === 1) question.points = 5;
                        else if (question.attempts === 2) question.points = 3;
                        else if (question.attempts === 3) question.points = 1;
                        else question.points = 0;

                        question.feedback = `✅ Yay your answer is correct, let's move on to the next question! Point: ${question.points}`;
                        question.feedbackColor = 'text-green-600';
                        question.answered = true;
                    } else {
                        if (question.attempts >= 3) {
                            question.feedback = '❌ Incorrect and tried 3 times. Points not awarded. Lets choose the last answer!';
                     
                        } else {
                            question.feedback = `❌ Wrong answer. (Trial ${question.attempts})`;
                        }
                        question.feedbackColor = 'text-red-600';
                    }
                },
                submitAll() {
                    alert('Jawaban dikumpulkan!');
                    // bisa dilanjutkan submit ke backend
                }
            }
        }
    </script>
@endsection