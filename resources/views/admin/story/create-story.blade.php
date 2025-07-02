@extends('admin.layouts.app')


@section('content')
  @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100">
    ✅ {{ session('success') }}
    </div>
  @endif

  <div class="container-fluid mt-4">
    <div class="mb-6">
    <div class="mb-6">
      <h2 class="text-3xl font-extrabold text-gray-800">Manage Story</h2>
      <p class="text-gray-500 mt-1">Manage Story Detail.</p>
    </div>
    </div>
    {{-- Header dan Tombol --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

    <button type="button" data-bs-toggle="modal" data-bs-target="#addStoryModal"
      class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">+
      Add Story Title</button>
    </div>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <!-- Modal -->
    <div class="modal fade" id="addStoryModal" tabindex="-1" aria-labelledby="addStoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.store-story') }}" method="POST" enctype="multipart/form-data" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addStoryModalLabel">Add Story Title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
        <label for="title" class="form-label">Story Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-4">
        <label for="cover" class="block text-sm font-medium text-gray-700">Story Cover Image</label>
        <input type="file" id="cover" name="cover" accept="image/*" required
          class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" />

        <!-- Image preview -->
        <div class="mt-4">
          <img id="coverPreview" src="" alt="Preview"
          class="hidden w-full max-h-60 object-contain rounded border border-gray-300 shadow" />
        </div>
        </div>


      </div>
      <div class="modal-footer">

        <button type="submit"
        class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
        Save</button>

        <button type="button"
        class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
        data-bs-dismiss="modal">Cancel</button>

      </div>
      </form>
    </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
      <thead class="text-center text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr class="text-center">
        <th scope="col" class="px-6 py-3">
        No
        </th>
        <th scope="col" class="px-6 py-3">
        Title
        </th>
        <th scope="col" class="px-6 py-3">
        Cover
        </th>
        <th scope="col" class="px-6 py-3">
        Action
        </th>
      </tr>
      </thead>

      <tbody>
      @foreach ($stories as $story)
      <tr
        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 text-center">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $story->title }}</td>
        <td class="p-4">
        @if ($story->cover)
      <img src="{{ asset('storage/' . $story->cover) }}" alt="Story Cover" class="w-32 h-auto mx-auto rounded">
      @else
      No cover image
      @endif
        </td>
        <td>
        <a href="{{ route('admin.detail-story', $story->id) }}"
        class="inline-block text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-md text-xs px-3 py-1.5 text-center me-2 mb-2">
        Add Detail
        </a>

        <button type="button"
        class="btn-edit-story text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-md text-xs px-3 py-1.5 text-center me-2 mb-2"
        data-id="{{ $story->id }}" data-title="{{ $story->title }}"
        data-cover="{{ asset('storage/' . $story->cover) }}" data-bs-toggle="modal"
        data-bs-target="#editStoryModal">
        Edit
        </button>


        <form action="{{ route('admin.delete-story', $story->id) }}" method="POST" class="inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button"
        class="btn-delete-story inline-block text-white bg-red-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-md text-xs px-3 py-1.5 text-center me-2 mb-2"
        data-story-id="{{ $story->id }}">
        Delete
        </button>
        </form>


      </tr>
    @endforeach
      </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal fade" id="editStoryModal" tabindex="-1" aria-labelledby="editStoryModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <form id="editStoryForm" method="POST" enctype="multipart/form-data" class="modal-content">
        @csrf
        @method('PUT')
        <div class="modal-header">
        <h5 class="modal-title" id="editStoryModalLabel">Edit Story</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
        <input type="hidden" name="story_id" id="editStoryId">
        <div class="mb-3">
          <label for="editTitle" class="form-label">Story Title</label>
          <input type="text" class="form-control" id="editTitle" name="title" required>
        </div>
        <div class="mb-4">
          <label for="editCover" class="form-label">Cover Image</label>
          <input type="file" class="form-control" id="editCover" name="cover">
          <div class="mt-4">
          <img id="editCoverPreview" src="" alt="Cover Preview"
            class="w-full max-h-60 object-contain rounded border mt-2">
          </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="submit"
          class="text-white bg-yellow-500 hover:bg-yellow-600 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5">
          Update
        </button>
        <button type="button"
          class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
          data-bs-dismiss="modal">
          Cancel
        </button>

        </div>
      </form>
      </div>
    </div>

    </div>
  </div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
  // --- DELETE STORY ---
  const deleteButtons = document.querySelectorAll('.btn-delete-story');
  deleteButtons.forEach(button => {
    button.addEventListener('click', function () {
      const form = this.closest('form');
      Swal.fire({
        title: 'Are you sure you want to delete??',
        text: "Deleted data cannot be recovered!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete!',
        cancelButtonText: 'Cancel',
        customClass: {
          confirmButton: 'bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700',
          cancelButton: 'bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600'
        }
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  // --- PREVIEW COVER SAAT ADD STORY ---
  const coverInput = document.getElementById('cover');
  const previewImage = document.getElementById('coverPreview');

  if (coverInput) {
    coverInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImage.src = e.target.result;
          previewImage.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
      } else {
        previewImage.src = "";
        previewImage.classList.add('hidden');
      }
    });
  }

  // --- EDIT STORY ---
  const editButtons = document.querySelectorAll('.btn-edit-story');
  const editForm = document.getElementById('editStoryForm');
  const editTitleInput = document.getElementById('editTitle');
  const editCoverPreview = document.getElementById('editCoverPreview');
  const editCoverInput = document.getElementById('editCover');

  editButtons.forEach(button => {
    button.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const title = this.getAttribute('data-title');
      const cover = this.getAttribute('data-cover');

      editTitleInput.value = title;
      editCoverPreview.src = cover;
      editCoverPreview.classList.remove('hidden');

      editForm.action = `/admin/story/${id}`;
    });
  });

  if (editCoverInput) {
    editCoverInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function (e) {
          editCoverPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }
});
</script>
