@php
    use Illuminate\Support\Facades\Auth;
@endphp

<nav class="bg-white border-b border-gray-200 dark:bg-gray-900 z-50">
  <div class="flex flex-wrap items-center justify-between px-6 py-4">
    <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
    </a>

    <!-- Right Menu -->
    <div class="flex items-center space-x-4">
      <button type="button"
        class="relative flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
        id="user-menu-button" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
        <img class="w-8 h-8 rounded-full"
            src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
            alt="User photo">
    </button>

      <!-- Dropdown -->
      <div id="user-dropdown"
        class="z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
        <div class="px-4 py-3">
          <span class="block text-sm text-gray-900 dark:text-white">Signed in as</span>
          <span class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
        </div>
        <ul class="py-2" aria-labelledby="user-menu-button">
          <li><a href="#"
              class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit
              Profile</a>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit"
                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                Sign out
              </button>
            </form>
          </li>

        </ul>
      </div>
    </div>
  </div>
</nav>