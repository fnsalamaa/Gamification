@extends('admin.layouts.app')

<div class="container-fluid">

  @section('content')
    <div class="top">
    <section class="section">
      <div class="section-body">
      <div class="row no-gutters">
        <div class="col-12">

        {{-- FORM UNTUK DETAIL CERITA --}}
        <div class="card shadow shadow-sm mb-4 p-4">
          <h5>Detail Cerita</h5>
          <form action="{{ route('admin.store-detail', $story->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group mb-3">
            <label for="title"><strong>Story Title</strong></label>
            <input type="text" class="form-control" id="title" name="title" value="{{ $story->title }}" readonly>
          </div>
          </form>
        </div>

        {{-- FORM-FORM UNTUK TIAP STAGE --}}
        @foreach ($stages as $stage)
        <div class="card mb-4 p-4 border">
        <div class="mb-3">
        <strong>Stage {{ $stage->order }} - {{ ucfirst($stage->stage_type) }}</strong>
        <p>Jumlah soal: {{ $stage->questions->count() }} / 5</p>
        </div>

        @if ($stage->questions->count() > 0)
        <div class="mb-3">
        <h6>Daftar Soal Stage {{ $stage->order }}</h6>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead
        class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
        <th scope="col" class="px-6 py-3">No</th>
        <th scope="col" class="px-6 py-3">Narrative</th>
        <th scope="col" class="px-6 py-3">Pertanyaan</th>
        <th scope="col" class="px-6 py-3">Jawaban A</th>
        <th scope="col" class="px-6 py-3">Jawaban B</th>
        <th scope="col" class="px-6 py-3">Jawaban C</th>
        <th scope="col" class="px-6 py-3">Jawaban D</th>
        <th scope="col" class="px-6 py-3">Benar</th>
        <th scope="col" class="px-6 py-3">Gambar</th>
        <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($stage->questions as $index => $question)
        <tr
        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">
        <td>{{ $index + 1 }}</td>
        <td class="text-wrap mw-100">{{ $question->narrative }}</td>
        <td class="text-wrap mw-100">{{ $question->question_text }}</td>
        <td>{{ $question->option_a }}</td>
        <td>{{ $question->option_b }}</td>
        <td>{{ $question->option_c }}</td>
        <td>{{ $question->option_d }}</td>
        <td>{{ $question->correct_answer }}</td>
        <td>
        @if ($question->image)
        <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Soal" width="80">
        @else
        <em>Tidak ada</em>
        @endif
        </td>
        <td>
        <button type="button"
        class="inline-block text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 dark:focus:ring-yellow-600 font-medium rounded-md text-xs px-3 py-1.5 text-center me-2 mb-2"
        data-bs-toggle="modal" data-bs-target="#editModal-{{ $question->id }}">
        Edit
        </button>

        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
        class="inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button"
        class="btn-delete inline-block text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-700 font-medium rounded-md text-xs px-3 py-1.5 text-center me-2 mb-2">
        Hapus
        </button>
        </form>
        </td>
        </tr>

        {{-- MODAL EDIT --}}
        <div class="modal fade" id="editModal-{{ $question->id }}" tabindex="-1"
        aria-labelledby="editModalLabel-{{ $question->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <form action="{{ route('admin.questions.update', $question->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel-{{ $question->id }}">Edit Soal</h5>
        <button type="button" class="text-gray-500 hover:text-gray-700 text-2xl font-bold ml-auto"
        data-bs-dismiss="modal" aria-label="Tutup">
        &times;
        </button>

        </div>
        <div class="modal-body">
        <div class="mb-3">
        <label><strong>Narasi</strong></label>
        <textarea name="narrative" class="form-control" rows="5"
        style="resize: vertical; word-wrap: break-word;">{{ $question->narrative }}</textarea>
        </div>
        <div class="mb-3">
        <label><strong>Pertanyaan</strong></label>
        <textarea name="question_text" class="form-control" rows="5"
        style="resize: vertical; word-wrap: break-word;">{{ $question->question_text }}</textarea>
        </div>
        <div class="row mb-2">
        <div class="col-md-6">
        <label>Jawaban A</label>
        <input type="text" name="option_a" class="form-control"
        value="{{ $question->option_a }}">
        </div>
        <div class="col-md-6">
        <label>Jawaban B</label>
        <input type="text" name="option_b" class="form-control"
        value="{{ $question->option_b }}">
        </div>
        </div>
        <div class="row mb-2">
        <div class="col-md-6">
        <label>Jawaban C</label>
        <input type="text" name="option_c" class="form-control"
        value="{{ $question->option_c }}">
        </div>
        <div class="col-md-6">
        <label>Jawaban D</label>
        <input type="text" name="option_d" class="form-control"
        value="{{ $question->option_d }}">
        </div>
        </div>
        <div class="mb-3">
        <label>Jawaban Benar</label>
        <select name="correct_answer" class="form-select">
        <option value="A" {{ $question->correct_answer == 'A' ? 'selected' : '' }}>A</option>
        <option value="B" {{ $question->correct_answer == 'B' ? 'selected' : '' }}>B</option>
        <option value="C" {{ $question->correct_answer == 'C' ? 'selected' : '' }}>C</option>
        <option value="D" {{ $question->correct_answer == 'D' ? 'selected' : '' }}>D</option>
        </select>
        </div>
        <div class="mb-3">
        <label>Gambar (opsional)</label>
        <input type="file" name="image" class="form-control">
        @if ($question->image)
        <img src="{{ asset('storage/' . $question->image) }}" alt="Gambar Soal" width="100"
        class="mt-2">
        @endif
        </div>
        </div>
        <div class="modal-footer">
        <button type="submit"
        class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
        Save</button>
        </div>
        </form>
        </div>
        </div>
        </div>
        @endforeach
        </tbody>
        </table>
        </div>
      @endif

        {{-- TAMBAH SOAL JIKA KURANG DARI 5 --}}
        @if ($stage->questions->count() < 5)
        <form action="{{ route('admin.questions.store', $stage->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @php $remaining = 5 - $stage->questions->count(); @endphp

        @for ($i = 0; $i < $remaining; $i++)
        <div class="border p-3 mb-3 rounded">
        <h6>Soal ke-{{ $stage->questions->count() + $i + 1 }}</h6>
        <div class="form-group mb-2">
        <label><strong>Narasi</strong></label>
        <textarea name="questions[{{ $i }}][narrative]" class="form-control" required></textarea>
        </div>
        <div class="form-group mb-2">
        <strong>Gambar (opsional)</strong>
        <input type="file" name="questions[{{ $i }}][image]" class="form-control image-input"
        data-preview="preview-{{ $i }}-{{ $stage->id }}">
        <img id="preview-{{ $i }}-{{ $stage->id }}" src="#" alt="Preview"
        style="display:none; max-height: 150px; margin-top: 10px;">
        </div>
        <div class="form-group mb-2">
        <strong>Pertanyaan</strong>
        <input type="text" name="questions[{{ $i }}][question_text]" class="form-control" required>
        </div>
        <div class="row mb-2">
        <div class="col-md-6">
        <strong>Jawaban A</strong>
        <input type="text" name="questions[{{ $i }}][option_a]" class="form-control" required>
        </div>
        <div class="col-md-6">
        <strong>Jawaban B</strong>
        <input type="text" name="questions[{{ $i }}][option_b]" class="form-control" required>
        </div>
        </div>
        <div class="row mb-2">
        <div class="col-md-6">
        <strong>Jawaban C</strong>
        <input type="text" name="questions[{{ $i }}][option_c]" class="form-control" required>
        </div>
        <div class="col-md-6">
        <strong>Jawaban D</strong>
        <input type="text" name="questions[{{ $i }}][option_d]" class="form-control" required>
        </div>
        </div>
        <div class="form-group mb-2">
        <strong>Jawaban Benar</strong>
        <select name="questions[{{ $i }}][correct_answer]" class="form-select" required>
        <option value="">-- Pilih --</option>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
        </select>
        </div>
        </div>
      @endfor

        <button type="submit" class="btn btn-outline-primary">
        <i class="fa fa-save"></i> Simpan {{ $remaining }} Soal
        </button>
        </form>
      @else
        <div class="alert alert-success mt-2">
        Stage ini sudah memiliki 5 soal.
        </div>
      @endif
        </div>
        @endforeach

        <a href="{{ route('admin.create-story') }}" class="btn btn-secondary">Kembali</a>
        </div>
      </div>
      </div>
    </section>
    </div>
  </div>

@endsection


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const imageInputs = document.querySelectorAll(".image-input");

    imageInputs.forEach(input => {
      input.addEventListener("change", function (e) {
        const previewId = this.getAttribute("data-preview");
        const previewImage = document.getElementById(previewId);
        const file = this.files[0];

        if (file) {
          const reader = new FileReader();
          reader.onload = function (event) {
            previewImage.src = event.target.result;
            previewImage.style.display = "block";
          };
          reader.readAsDataURL(file);
        } else {
          previewImage.style.display = "none";
          previewImage.src = "#";
        }
      });
    });
  });



  document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
        const form = button.closest('form');

        Swal.fire({
          title: 'Yakin ingin menghapus?',
          text: "Data tidak bisa dikembalikan setelah dihapus.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Ya, hapus!',
          cancelButtonText: 'Batal',
          customClass: {
            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-md mr-2',
            cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium px-4 py-2 rounded-md'
          },
          buttonsStyling: false // supaya Tailwind class digunakan
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  });





</script>
@if (session('success'))
  <script>
    Swal.fire({
    icon: 'success',
    title: 'Berhasil!',
    text: '{{ session("success") }}',
    timer: 2000,
    showConfirmButton: false
    });
  </script>
@endif