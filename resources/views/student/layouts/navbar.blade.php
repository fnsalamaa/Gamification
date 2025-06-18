<nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

    <!-- Logo -->
    <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
    </a>

    <!-- Tombol hamburger (mobile) -->
    <button data-collapse-toggle="navbar-user" type="button"
      class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
      aria-controls="navbar-user" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M1 1h15M1 7h15M1 13h15" />
      </svg>
    </button>

    <!-- Tombol Logout (desktop) -->
    <div class="hidden md:flex items-center md:order-2 space-x-3">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
          class="text-sm bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg focus:ring-2 focus:ring-red-300 dark:focus:ring-red-800">
          Sign Out
        </button>
      </form>
    </div>

    <!-- Menu navigasi utama -->
    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
      <ul
        class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="{{ route('student.dashboard') }}"
            class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500">
            Home</a>
        </li>
        <li>
          <a href="{{ route('student.story.chooseStory') }}"
            class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500">
            Story</a>
        </li>
        <li>
          <a href="{{ route('student.badge.choose') }}"
            class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500">
            Badge</a>
        </li>
        <li>
          <a href="{{ route('student.avatar.choose') }}"
            class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500">
            Avatar</a>
        </li>
        <li>
          <a href="{{ route('student.leaderboard.global') }}"
            class="block py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500">
            Leaderboard
          </a>
        </li>


        <!-- Tombol Logout (mobile, hanya muncul saat menu terbuka) -->
        <li class="md:hidden">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="w-full text-left text-sm bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg mt-2">
              Sign Out
            </button>
          </form>
        </li>

      </ul>
    </div>

  </div>
</nav>