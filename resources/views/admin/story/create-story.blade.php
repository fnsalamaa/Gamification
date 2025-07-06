@extends('admin.layouts.app')

@section('content')
@if(session('success'))
<div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100">
  ✅ {{ session('success') }}
</div>
@endif

<div class="container-fluid mt-4 px-4 sm:px-6 lg:px-8" x-data="{ openAddModal: false, openEditModal: false, previewUrl: null, editPreviewUrl: null }">
  <div class="mb-8">
    <h2 class="text-3xl font-extrabold text-gray-800">📚 Manage Story</h2>
    <p class="text-gray-500 mt-1">You can create, edit, or remove story titles and covers here.</p>
  </div>

  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
    <button @click="openAddModal = true"
      class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-semibold rounded-lg text-sm px-6 py-3 transition-all">
      ＋ Add New Story
    </button>
  </div>

  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  <!-- Add Modal -->
  <div x-show="openAddModal" x-transition x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4">
    <div @click.outside="openAddModal = false" class="bg-white rounded-xl w-full max-w-lg p-6 sm:p-8 shadow-2xl">
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Story</h2>
      <form action="{{ route('admin.store-story') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Story Title</label>
          <input type="text" id="title" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
          <label for="cover" class="block text-sm font-medium text-gray-700">Cover Image</label>
          <input type="file" id="cover" name="cover" accept="image/*"  @change="previewUrl = URL.createObjectURL($event.target.files[0])" class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 cursor-pointer" required/>
          <template x-if="previewUrl">
            <img :src="previewUrl" alt="Preview" class="mt-4 w-full max-h-60 object-contain rounded-lg border border-gray-300 shadow-sm" />
          </template>
        </div>

        <div class="flex justify-end space-x-2 pt-4">
          <button type="button" @click="openAddModal = false" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">Save</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Table -->
  <div class="relative overflow-x-auto bg-white rounded-xl shadow-md">
    <table class="w-full text-sm text-left text-gray-600">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr class="text-center">
          <th scope="col" class="px-4 py-3">No</th>
          <th scope="col" class="px-4 py-3">Title</th>
          <th scope="col" class="px-4 py-3">Cover</th>
          <th scope="col" class="px-4 py-3">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($stories as $story)
        <tr class="bg-white border-b hover:bg-gray-50 text-center">
          <td class="px-4 py-2">{{ $loop->iteration }}</td>
          <td class="px-4 py-2 font-medium text-gray-800">{{ $story->title }}</td>
          <td class="px-4 py-2">
            @if ($story->cover)
            <img src="{{ asset('storage/' . $story->cover) }}" alt="Cover" class="w-24 h-auto mx-auto rounded shadow-md" />
            @else
            <span class="text-gray-400">No image</span>
            @endif
          </td>
          <td class="px-4 py-2">
            <div class="flex flex-col md:flex-row justify-center items-center gap-2">
              <a href="{{ route('admin.detail-story', $story->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md">Detail</a>
              <button type="button" @click="openEditModal = true; $nextTick(() => { document.getElementById('editTitle').value = '{{ $story->title }}'; document.getElementById('editStoryId').value = '{{ $story->id }}'; editPreviewUrl = '{{ asset('storage/' . $story->cover) }}'; document.getElementById('editStoryForm').action = '/admin/story/{{ $story->id }}'; })" class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-3 py-1.5 rounded-md">Edit</button>
              <form action="{{ route('admin.delete-story', $story->id) }}" method="POST" class="inline delete-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-delete-story bg-red-500 hover:bg-red-600 text-white text-xs font-semibold px-3 py-1.5 rounded-md" data-story-id="{{ $story->id }}">Delete</button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Edit Modal -->
  <div x-show="openEditModal" x-transition x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4">
    <div @click.outside="openEditModal = false" class="bg-white rounded-xl w-full max-w-lg p-6 sm:p-8 shadow-2xl">
      <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Story</h2>
      <form id="editStoryForm" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" name="story_id" id="editStoryId">
        <div>
          <label for="editTitle" class="block text-sm font-medium text-gray-700">Story Title</label>
          <input type="text" id="editTitle" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
          <label for="editCover" class="block text-sm font-medium text-gray-700">Cover Image</label>
          <input type="file" id="editCover" name="cover" @change="editPreviewUrl = URL.createObjectURL($event.target.files[0])" class="mt-1 block w-full rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 cursor-pointer" />
          <template x-if="editPreviewUrl">
            <img :src="editPreviewUrl" alt="Preview" class="mt-4 w-full max-h-60 object-contain rounded-lg border border-gray-300 shadow-sm" />
          </template>
        </div>

        <div class="flex justify-end space-x-2 pt-4">
          <button type="button" @click="openEditModal = false" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-sm font-medium rounded-md">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded-md">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete-story');
    deleteButtons.forEach(button => {
      button.addEventListener('click', function () {
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
@endsection




