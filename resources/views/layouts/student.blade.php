<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    @media (min-width: 768px) {
      #sidebar {
        width: 250px;
        min-height: 100vh;
        border-right: 1px solid #dee2e6;
      }

      #mainContent {
        flex: 1;
      }

      .navbar {
        position: sticky;
        top: 0;
        z-index: 1020;
      }
    }

    @media (max-width: 767.98px) {
      #sidebar {
        width: 250px;
      }
    }
  </style>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
<div class="d-flex">

  {{-- Sidebar --}}
  <div id="sidebar" class="bg-white border-end d-none d-md-block" style="width: 250px; min-height: 100vh;">
    <div class="p-3">
      <h5>Menu</h5>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a href="{{ route('student.dashboard') }}" class="nav-link text-dark">Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('admin.create-story') }}" class="nav-link text-dark">Story</a></li>
        <li class="nav-item"><a href="#" class="nav-link text-dark">Users</a></li>
        <li class="nav-item"><a href="#" class="nav-link text-dark">Settings</a></li>
      </ul>
    </div>
  </div>

  {{-- Offcanvas Sidebar (untuk layar kecil) --}}
  <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="offcanvasSidebar" style="width: 250px;">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menu</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="nav nav-pills flex-column">
        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link text-dark">Dashboard</a></li>
        <li class="nav-item"><a href="{{ route('admin.create-story') }}" class="nav-link text-dark">Story</a></li>
        <li class="nav-item"><a href="#" class="nav-link text-dark">Users</a></li>
        <li class="nav-item"><a href="#" class="nav-link text-dark">Settings</a></li>
      </ul>
    </div>
  </div>

  {{-- Main Content --}}
  <div class="flex-grow-1">

    {{-- Navbar --}}
<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom shadow-sm sticky-top">
  <div class="container-fluid">

    {{-- Tombol toggle sidebar (hanya di layar kecil) --}}
    <button class="btn btn-outline-secondary d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
      ☰
    </button>

    {{-- Brand / Judul --}}
    <a class="navbar-brand mb-0 h1" href="#">Admin Panel</a>

    {{-- Spacer agar tombol logout di kanan --}}
    <div class="ms-auto">
      <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-outline-danger">
          Logout
        </button>
      </form>
    </div>

  </div>
</nav>


    {{-- Isi halaman --}}
    <div class="p-4">
      @yield('content')
    </div>

  </div>
</div>

</body>
</html>
