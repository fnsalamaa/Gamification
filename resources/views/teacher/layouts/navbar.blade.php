<nav class="bg-white border-b border-gray-200 shadow-sm">
  <div class="max-w-screen-xl mx-auto flex flex-wrap items-center justify-between p-4">

    <!-- Logo -->
    <a href="{{ route('teacher.dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="{{ asset('storage/welcome/logo3.png') }}" class="h-12 sm:h-14" alt="Logo" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap text-gray-800">Lores of Java</span>
    </a>

    <!-- Hamburger Menu (Mobile) -->
    <button data-collapse-toggle="navbar-teacher" type="button"
      class="inline-flex items-center p-2 w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
      aria-controls="navbar-teacher" aria-expanded="false">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" fill="none" viewBox="0 0 17 14" xmlns="http://www.w3.org/2000/svg">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M1 1h15M1 7h15M1 13h15" />
      </svg>
    </button>

    <!-- Menu dan Logout -->
    <div class="hidden w-full md:flex md:items-center md:w-auto" id="navbar-teacher">
      <ul
        class="flex flex-col font-medium mt-4 border border-gray-100 rounded-lg bg-white md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-transparent">
        <li>
          <a href="{{ route('teacher.dashboard') }}"
            class="block py-2 px-3 text-gray-800 hover:text-blue-700 md:p-0">Dashboard</a>
        </li>
        <li>
          <a href="{{ route('teacher.story.index') }}"
            class="block py-2 px-3 text-gray-800 hover:text-blue-700 md:p-0">Story</a>
        </li>
        <li>
          <a href="{{ route('teacher.students.show') }}"
            class="block py-2 px-3 text-gray-800 hover:text-blue-700 md:p-0">Student</a>
        </li>
        <li>
          <a href="{{ route('teacher.leaderboard') }}"
            class="block py-2 px-3 text-gray-800 hover:text-blue-700 md:p-0">Leaderboard</a>
        </li>

        <!-- Logout Mobile -->
        <li class="md:hidden">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="w-full text-left text-sm bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg mt-2">
              Log Out
            </button>
          </form>
        </li>
      </ul>
    </div>

    <!-- Logout Desktop -->
    <div class="hidden md:flex md:items-center space-x-3">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit"
          class="text-sm bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg focus:ring-2 focus:ring-red-300">
          Log Out
        </button>
      </form>
    </div>

  </div>
</nav>