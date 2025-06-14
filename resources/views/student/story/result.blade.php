@extends('student.layouts.app')

@section('content')
    <div class="max-w-xl mx-auto mt-12 text-center">
        <h1 class="text-3xl font-bold mb-6 text-green-600">🎉 {{ $story->title }} Completed!</h1>

        <p class="text-xl mb-4">
            Total Skor Kamu:
        </p>

        <div class="bg-white shadow-lg rounded-lg p-6 text-2xl font-semibold text-gray-800">
            {{ $totalScore }} dari {{ $maxScore }}
        </div>

        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700">
            Kembali ke Dashboard
        </a>
    </div>
@endsection
