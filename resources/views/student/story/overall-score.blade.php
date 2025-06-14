@extends('student.layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-12 text-center">
        <h1 class="text-3xl font-bold mb-6 text-blue-600">📊 Total Skor Kamu</h1>

        <p class="text-xl mb-4">
            Dari semua cerita yang kamu kerjakan:
        </p>

        <div class="bg-white shadow-lg rounded-lg p-6 text-2xl font-semibold text-gray-800">
            {{ $totalScore }} dari {{ $maxScore }}
        </div>
    </div>
@endsection
