@extends('admin.layouts.app')

@section('content')
  @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100">
    ✅ {{ session('success') }}
    </div>
  @endif

  <div class="container-fluid">

    <div class="top">
    <section class="section">
      <div class="section-body">
      <div class="w-full">

        <!-- FORM DETAIL CERITA -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">📘 Story Detail</h2>
        <form action="{{ route('admin.store-detail', $story->id) }}" method="POST" enctype="multipart/form-data"
          class="space-y-4">
          @csrf
          <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Story Title</label>
          <input type="text" id="title" name="title" value="{{ $story->title }}" readonly
            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md bg-gray-100 text-gray-700" />
          </div>
        </form>
        </div>

        <!-- TIAP STAGE -->
        @php
      $mainEventCounter = 1;
    @endphp

        @foreach ($stages as $stage)
      <div x-data="{ accordionOpen: false }"
      class="mb-6 border border-gray-300 rounded-xl shadow bg-white overflow-hidden">

      <!-- Dropdown Button -->
      <button @click="accordionOpen = !accordionOpen"
        class="w-full text-left px-6 py-4 text-gray-800 font-semibold flex justify-between items-center">
        🎯
        @if ($stage->stage_type === 'opening')
      Opening
      @elseif ($stage->stage_type === 'main_event')
      Main Event {{ $mainEventCounter++ }}
      @elseif ($stage->stage_type === 'closure')
      Closure
      @endif


        <svg :class="{ 'rotate-180': accordionOpen }" class="w-5 h-5 transition-transform duration-300"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>

      <!-- Isi dropdown -->
      <div x-show="accordionOpen" x-collapse class="p-6">
        <p class="text-sm text-gray-500 mb-3">Jumlah soal: {{ $stage->questions->count() }} / 5</p>

        {{-- TABEL SOAL --}}
        @if ($stage->questions->count() > 0)
      <div class="overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-600 border border-gray-200 rounded-lg overflow-hidden">
        <thead class="text-xs uppercase bg-gray-100 text-gray-700">
        <tr class="text-center">
        <th class="px-3 py-2">No</th>
        <th class="px-3 py-2">Narrative</th>
        <th class="px-3 py-2">Pertanyaan</th>
        <th class="px-3 py-2">A</th>
        <th class="px-3 py-2">B</th>
        <th class="px-3 py-2">C</th>
        <th class="px-3 py-2">D</th>
        <th class="px-3 py-2">Benar</th>
        <th class="px-3 py-2">Gambar</th>
        <th class="px-3 py-2">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($stage->questions as $index => $question)
      <tr class="border-b text-center hover:bg-gray-50">
        <td class="px-2 py-2">{{ $index + 1 }}</td>
        <td class="px-2 py-2 max-w-xs break-words">{{ $question->narrative }}</td>
        <td class="px-2 py-2 max-w-xs break-words">{{ $question->question_text }}</td>
        <td class="px-2 py-2">{{ $question->option_a }}</td>
        <td class="px-2 py-2">{{ $question->option_b }}</td>
        <td class="px-2 py-2">{{ $question->option_c }}</td>
        <td class="px-2 py-2">{{ $question->option_d }}</td>
        <td class="px-2 py-2 font-semibold">{{ $question->correct_answer }}</td>
        <td class="px-2 py-2">
        @if ($question->image)
      <img src="{{ asset('storage/' . $question->image) }}"
      class="w-20 h-auto mx-auto rounded shadow" />
      @else
      <span class="text-gray-400 italic">Tidak ada</span>
      @endif
        </td>
        <td class="px-2 py-2 space-y-1 flex flex-col items-center">
        <!-- Modal Edit -->
        <div x-data="{ modalOpen: false }" class="relative">
        <button @click="modalOpen = true" type="button"
        class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-3 py-1 rounded-md">Edit</button>

        <div x-show="modalOpen" x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away.self="modalOpen = false"
        class="bg-white w-full max-w-3xl mx-auto p-6 rounded-xl shadow-xl relative">
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-800">Edit Soal</h3>
        <button type="button" @click="modalOpen  = false"
        class="text-2xl font-bold text-gray-500 hover:text-gray-700">&times;</button>
        </div>

        <div class="space-y-4">
        <div>
        <label class="block text-sm font-medium text-gray-700">Narasi</label>
        <textarea name="narrative" class="w-full p-2 border border-gray-300 rounded"
        rows="4">{{ $question->narrative }}</textarea>
        </div>
        <div>
        <label class="block text-sm font-medium text-gray-700">Pertanyaan</label>
        <textarea name="question_text" class="w-full p-2 border border-gray-300 rounded"
        rows="4">{{ $question->question_text }}</textarea>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div><label class="block text-sm">Jawaban A</label>
        <input type="text" name="option_a" class="w-full p-2 border rounded"
        value="{{ $question->option_a }}">
        </div>
        <div><label class="block text-sm">Jawaban B</label>
        <input type="text" name="option_b" class="w-full p-2 border rounded"
        value="{{ $question->option_b }}">
        </div>
        <div><label class="block text-sm">Jawaban C</label>
        <input type="text" name="option_c" class="w-full p-2 border rounded"
        value="{{ $question->option_c }}">
        </div>
        <div><label class="block text-sm">Jawaban D</label>
        <input type="text" name="option_d" class="w-full p-2 border rounded"
        value="{{ $question->option_d }}">
        </div>
        </div>
        <div>
        <label class="block text-sm font-medium text-gray-700">Jawaban Benar</label>
        <select name="correct_answer" class="w-full p-2 border rounded">
        <option value="A" {{ $question->correct_answer == 'A' ? 'selected' : '' }}>A
        </option>
        <option value="B" {{ $question->correct_answer == 'B' ? 'selected' : '' }}>B
        </option>
        <option value="C" {{ $question->correct_answer == 'C' ? 'selected' : '' }}>C
        </option>
        <option value="D" {{ $question->correct_answer == 'D' ? 'selected' : '' }}>D
        </option>
        </select>
        </div>
        <div
        x-data="{ previewUrl: '{{ $question->image ? asset('storage/' . $question->image) : '' }}' }">
        <label class="block text-sm font-medium">Gambar (opsional)</label>
        <input type="file" name="image"
        @change="previewUrl = URL.createObjectURL($event.target.files[0])"
        class="w-full text-sm">
        <template x-if="previewUrl">
        <img :src="previewUrl" alt="Preview"
        class="mt-2 w-24 h-auto rounded shadow max-w-full">
        </template>
        </div>
        </div>

        <div class="mt-6 text-right">
        <button type="submit"
        class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-md">
        Simpan
        </button>
        </div>
        </form>
        </div>
        </div>
        </div>

        <!-- Tombol Hapus -->
        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
        class="inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button"
        class="btn-delete bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md">Hapus</button>
        </form>
        </td>
      </tr>
      @endforeach
        </tbody>
      </table>
      </div>
      @endif

        {{-- FORM TAMBAH SOAL --}}
        @if ($stage->questions->count() < 5)
      <form action="{{ route('admin.questions.store', $stage->id) }}" method="POST"
      enctype="multipart/form-data">
      @csrf
      @php $remaining = 5 - $stage->questions->count(); @endphp
      @for ($i = 0; $i < $remaining; $i++)
      <div class="border border-gray-300 rounded-lg p-4 mb-4">
      <h6 class="font-semibold mb-2">Soal ke-{{ $stage->questions->count() + $i + 1 }}</h6>
      <div class="mb-3">
      <label class="block text-sm">Narasi</label>
      <textarea name="questions[{{ $i }}][narrative]" class="w-full p-2 border rounded"
        required></textarea>
      </div>
      <div class="mb-3" x-data="{ previewUrl{{ $i }}: '' }">
      <label class="block text-sm">Gambar (opsional)</label>
      <input type="file" name="questions[{{ $i }}][image]"
        @change="previewUrl{{ $i }} = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : ''"
        class="w-full text-sm">
      <template x-if="previewUrl{{ $i }}">
        <img :src="previewUrl{{ $i }}" alt="Preview"
        class="mt-2 w-24 h-auto rounded shadow border border-gray-300 max-w-full">
      </template>
      </div>

      <div class="mb-3">
      <label class="block text-sm">Pertanyaan</label>
      <input type="text" name="questions[{{ $i }}][question_text]" class="w-full p-2 border rounded"
        required>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
      @foreach (['A', 'B', 'C', 'D'] as $opt)
      <div>
      <label class="block text-sm">Jawaban {{ $opt }}</label>
      <input type="text" name="questions[{{ $i }}][option_{{ strtolower($opt) }}]"
      class="w-full p-2 border rounded" required>
      </div>
      @endforeach
      </div>
      <div class="mb-3">
      <label class="block text-sm font-medium">Jawaban Benar</label>
      <select name="questions[{{ $i }}][correct_answer]" class="w-full p-2 border rounded" required>
        <option value="">-- Pilih --</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>
      </div>
      </div>
      @endfor
      <button type="submit"
        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
        <i class="fa fa-save"></i> Simpan {{ $remaining }} Soal
      </button>
      </form>
      @else
      <div class="p-4 bg-green-100 text-green-800 rounded-lg mt-2">Stage ini sudah memiliki 5 soal.</div>
      @endif

      </div>
      </div>
      @endforeach


        <a href="{{ route('admin.create-story') }}"
        class="inline-block mt-4 px-5 py-2 text-sm text-white bg-gray-600 hover:bg-gray-700 rounded-lg">
        ← Kembali
        </a>

      </div>
      </div>
    </section>
    </div>
  @endsection

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const deleteButtons = document.querySelectorAll('.btn-delete');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
          e.preventDefault();
          const form = this.closest('form');

          Swal.fire({
            title: 'Are you sure?',
            text: 'This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            customClass: {
              popup: 'px-6 py-4',
              confirmButton: 'swal2-confirm-button bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 focus:outline-none',
              cancelButton: 'swal2-cancel-button bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400 focus:outline-none'
            },
            buttonsStyling: false,
            didOpen: () => {
              const buttonContainer = Swal.getPopup().querySelector('.swal2-actions');
              if (buttonContainer) {
                buttonContainer.classList.add('flex', 'justify-center', 'gap-4', 'flex-wrap');
              }
            }
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit();
            }
          });
        });
      });
    });
  </script>