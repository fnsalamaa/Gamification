<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head config -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin App</title>

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind & Flowbite -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    
</head>

<body class="overflow-x-hidden bg-cover bg-center bg-no-repeat min-h-screen"
    style="background-image: url('{{ asset('storage/welcome/background.png') }}');">

    <div class="flex flex-col min-h-screen">

        {{-- Navbar --}}
        <div class="bg-white shadow z-50 sticky top-0 z-50">
            <div class="max-w-screen-xl mx-auto">
                @include('admin.layouts.navbar')
            </div>
        </div>

        {{-- Main Content --}}
        <main class="flex-1 p-4">
            <div class="max-w-screen-xl mx-auto">
                <div class="bg-white/80 backdrop-blur-md p-6 rounded-xl shadow relative z-0">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    {{-- Scripts --}}
    @yield('scripts')
</body>

</html>
