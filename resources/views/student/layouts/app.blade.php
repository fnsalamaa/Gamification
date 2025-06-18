<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App</title>

    {{-- Tailwind & Alpine --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Fredoka', sans-serif;
        }
    </style>
</head>

<body class="overflow-x-hidden bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('storage/welcome/background.png') }}');">

    <div class="flex h-screen">

        {{-- Main content area --}}
        <div class="flex flex-col flex-1 h-screen overflow-hidden">

            {{-- Navbar --}}
            @include('student.layouts.navbar')

            {{-- Main content --}}
            <main class="flex-1 overflow-y-auto p-4">
                {{-- Optional wrapper for content readability --}}
                <div class="bg-white/80 backdrop-blur-md p-6 rounded-xl shadow">
                    @yield('content')
                </div>
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

    {{-- Flowbite --}}
    <script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>

    {{-- Scripts section --}}
    @yield('scripts')  {{-- <<< Tambahkan baris ini --}}



</body>

</html>
