@php
  use Illuminate\Support\Facades\Auth;
@endphp

<nav class="bg-white border-b border-gray-200 z-50">
  <div class="max-w-screen-xl mx-auto flex flex-wrap items-center justify-between px-4 py-3">

    <!-- Logo -->
    <div class="flex items-center gap-3">
      <img src="{{ asset('storage/welcome/logo3.png') }}" class="h-10 w-10 object-contain" alt="Logo">
      <span class="text-indigo-800 text-xl font-bold">Lores of Java</span>
    </div>

    <!-- Hamburger Button (for mobile) -->
    <button data-collapse-toggle="mobile-menu" type="button"
      class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100"
      aria-controls="mobile-menu" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
          d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM4 14a1 1 0 100 2h12a1 1 0 100-2H4z"
          clip-rule="evenodd" />
      </svg>
    </button>

    <!-- Navigation Menu -->
    <div class="hidden w-full md:flex md:w-auto items-center justify-between" id="mobile-menu">
      <ul class="flex flex-col mt-4 font-medium md:flex-row md:space-x-6 md:mt-0">
        <li>
          <a href="{{ route('admin.dashboard') }}"
            class="block py-2 px-3 text-gray-700 rounded md:p-0 hover:text-indigo-600">Dashboard</a>
        </li>
        <li>
          <a href="{{ route('admin.create-story') }}"
            class="block py-2 px-3 text-gray-700 rounded md:p-0 hover:text-indigo-600">Story</a>
        </li>
        <li>
          <a href="{{ route('admin.users.show-users') }}"
            class="block py-2 px-3 text-gray-700 rounded md:p-0 hover:text-indigo-600">Users</a>
        </li>

        <!-- Mobile Logout Only -->
        <li class="block md:hidden border-t pt-3 mt-3">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="w-full text-left block px-3 py-2 text-sm text-red-600 hover:bg-red-100">
              Log out
            </button>
          </form>
        </li>
      </ul>
    </div>

    <!-- Desktop Logout Only -->
    <div class="hidden md:block ml-4">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="text-sm px-4 py-2 text-red-600 hover:bg-red-100 rounded-lg transition">
          Log out
        </button>
      </form>
    </div>

  </div>
</nav>
