<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body class="overflow-x-hidden">

    <div class="flex h-screen">

        {{-- Main content area --}}
        <div class="flex flex-col flex-1 h-screen overflow-hidden">

            {{-- Navbar --}}
            @include('student.layouts.navbar')

            {{-- Main content --}}
            <main class="flex-1 overflow-y-auto p-4 bg-gray-100">
                @yield('content')
            </main>
        </div>

    </div>

    {{-- Toggle sidebar script --}}
    <script>
        const toggleSidebar = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');

        toggleSidebar?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>

<!-- Tambahkan ini sebelum </body> -->
<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

</body>

</html>
