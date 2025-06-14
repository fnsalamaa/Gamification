@extends('admin.layouts.app')

@section('content')
    <div x-data="{
                                        open: false,
                                        openEdit: false,
                                        role: '',
                                        editUser: {
                                            id: null,
                                            name: '',
                                            email: '',
                                            role: '',
                                            class: ''
                                        }
                                    }" class="max-w-7xl mx-auto px-4 py-8">

        <!-- Judul Halaman -->
        <div class="mb-6">
            <h2 class="text-3xl font-extrabold text-gray-800">Manage Users</h2>
            <p class="text-gray-500 mt-1">Manage user accounts and their roles.</p>
        </div>

        <!-- Header Tabel: Tombol + Search -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
            <!-- Left: Add User Button -->
            <button @click="open = true"
                class="flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition transform duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add User
            </button>

            <!-- Right: Search -->
            <div x-data="{ search: '{{ request('search') }}' }">
                <input type="text" x-model="search"
                    x-on:input.debounce.500ms="window.location.href = '{{ route('admin.users.show-users') }}?search=' + encodeURIComponent(search)"
                    placeholder="Search users..."
                    class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring focus:border-blue-300" />
            </div>
        </div>


        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr class="text-center">
                        <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase">Profile</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase">Name</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase">Role</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-600 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="text-center">
                            <td class="px-6 py-4">
                                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                                    alt="Profile" class="w-10 h-10 rounded-full object-cover">

                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 capitalize">
                                @php
                                    $roleMap = ['admin' => 'Admin', 'teacher' => 'Teacher', 'user' => 'Student'];
                                    $displayRoles = $user->roles->pluck('name')->map(fn($r) => $roleMap[$r] ?? $r)->join(', ');
                                @endphp
                                {{ $displayRoles ?: '-' }}
                            </td>


                            <td class="px-6 py-4 flex items-center gap-2 justify-center">
                                <button @click="openEdit = true;
                                                                            editUser.id = {{ $user->id }};
                                                                            editUser.name = '{{ $user->name }}';
                                                                            editUser.email = '{{ $user->email }}';
                                                                            editUser.role = '{{ optional($user->roles->first())->name }}';
                                                                            editUser.class = '{{ $user->class ?? '' }}';
                                                                        "
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs font-semibold px-3 py-1.5 rounded-md shadow">
                                    Edit
                                </button>


                                <div x-data="{ showDelete: false }">
                                    <!-- Tombol Delete -->
                                    <button @click="showDelete = true"
                                        class="flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1.5 rounded-lg shadow transition">
                                        
                                        Delete
                                    </button>

                                    <!-- Modal Konfirmasi Tengah -->
                                    <div x-show="showDelete" x-cloak
                                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-auto relative">
                                            <h2 class="text-lg font-semibold text-gray-800 mb-3 text-center">Confirm Deletion
                                            </h2>
                                            <p class="text-sm text-gray-600 mb-4">Are you sure you want to delete this user?
                                                This action cannot be undone.</p>
                                            <div class="flex justify-center gap-3 mt-4">
                                                <button @click="showDelete = false"
                                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">
                                                    Cancel
                                                </button>

                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->appends(request()->input())->links() }}
        </div>





        <!-- Modal Add -->
        <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>

            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative z-60">
                <h3 class="text-lg font-semibold mb-4">Add New User</h3>
                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" name="name" required class="w-full border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Email</label>
                            <input type="email" name="email" required class="w-full border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Profile Photo</label>
                            <input type="file" name="profile_photo" class="w-full border-gray-300 rounded-lg p-2" />
                        </div>
                        <div class="flex gap-4">
                            <div class="w-1/2">
                                <label class="block text-sm font-medium">Password</label>
                                <input type="password" name="password" required
                                    class="w-full border-gray-300 rounded-lg p-2" />
                            </div>
                            <div class="w-1/2">
                                <label class="block text-sm font-medium">Confirm Password</label>
                                <input type="password" name="password_confirmation" required
                                    class="w-full border-gray-300 rounded-lg p-2" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Role</label>
                            <select name="role" x-model="role" required class="w-full border-gray-300 rounded-lg p-2">
                                <option value="" disabled selected>-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="user">Student</option>
                            </select>
                        </div>

                        <!-- Input class muncul hanya jika role == student -->
                        <div x-show="role === 'user'" class="transition-all">
                            <label class="block text-sm font-medium">Class</label>
                            <input type="text" name="class" class="w-full border-gray-300 rounded-lg p-2" />
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="button" @click="open = false" class="px-4 py-2 bg-gray-300 rounded-lg mr-2">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="openEdit" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative z-60">
                <h3 class="text-lg font-semibold mb-4">Edit User</h3>
                <form :action="`/admin/users/${editUser.id}`" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">Name</label>
                            <input type="text" name="name" x-model="editUser.name" required
                                class="w-full border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Email</label>
                            <input type="email" name="email" x-model="editUser.email" required
                                class="w-full border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Profile Photo</label>
                            <input type="file" name="profile_photo" class="w-full border-gray-300 rounded-lg p-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Role</label>
                            <select name="role" x-model="editUser.role" required
                                class="w-full border-gray-300 rounded-lg p-2">
                                <option value="" disabled>-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="user">Student</option>
                            </select>
                        </div>

                        <div x-show="editUser.role === 'user'" class="transition-all">
                            <label class="block text-sm font-medium">Class</label>
                            <input type="text" name="class" x-model="editUser.class"
                                class="w-full border-gray-300 rounded-lg p-2" />
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="button" @click="openEdit = false" class="px-4 py-2 bg-gray-300 rounded-lg mr-2">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

    </div>
@endsection