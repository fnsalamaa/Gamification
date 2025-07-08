<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&display=swap" rel="stylesheet">
    <style>
        .font-game {
            font-family: 'Press Start 2P', cursive;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center bg-no-repeat"
    style="background-image: url('{{ asset('storage/welcome/background.png') }}');">

    <div
        class="bg-white/90 p-10 rounded-3xl shadow-2xl max-w-5xl w-full flex flex-col md:flex-row items-center relative overflow-hidden backdrop-blur-sm">

        <!-- Stars and sparkles for game effect -->
        <div class="absolute top-2 left-2 text-yellow-400 text-2xl animate-bounce">⭐</div>
        <div class="absolute bottom-4 right-4 text-pink-400 text-xl animate-bounce">⭐</div>

        <!-- Gambar -->
        <div class="w-full md:w-1/2 mb-6 md:mb-0 md:mr-10">
            <img src="{{ asset('storage/welcome/welcome.jpeg') }}" alt="Welcome Game"
                class="rounded-xl shadow-lg w-full border-4 border-amber-500">
        </div>

        <!-- Konten -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-extrabold mb-4 text-amber-800 font-game">Javanese Ancestral Quest</h1>

            <p class="text-stone-700 mb-6 text-lg font-semibold">Ready to Discover the Myths?</p>
            <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                <a href="{{ route('login') }}"
                    class="bg-amber-700 text-white px-6 py-3 rounded-xl hover:bg-amber-800 shadow-lg transform hover:scale-105 transition-all duration-300">🔐
                    Start the Journey</a>
                {{-- <a href="{{ route('register') }}"
                    class="bg-yellow-200 text-gray-900 px-6 py-3 rounded-xl hover:bg-yellow-300 shadow-lg transform hover:scale-105 transition-all duration-300">📝
                    Register</a> --}}
            </div>
        </div>

    </div>

</body>

</html>