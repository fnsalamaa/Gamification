@extends('teacher.layouts.app')

@section('content')

  <div class="container-fluid mt-4">
    <div class="row mb-4">
    <div class="col">
      <h2>Dashboarrrd</h2>
      <p class="text-muted">Selamat datang di teacher.</p>
    </div>
{{-- 
    <p>Total Poin Kamu: {{ auth()->user()->student->totalPoints()
  () }}</p>

@if (auth()->user()->hasRole('user') && auth()->user()->student)
    <p>Total Poin Kamu: {{ auth()->user()->student->totalPoints() }}</p>
@else
    <p>Total Poin Kamu: Belum tersedia</p>
@endif --}}

    </div>
  @endsection