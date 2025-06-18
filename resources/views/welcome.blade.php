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

<body class="bg-gradient-to-br from-yellow-100 via-pink-200 to-red-200 min-h-screen flex items-center justify-center">

    <div
        class="bg-white p-10 rounded-3xl shadow-2xl max-w-5xl w-full flex flex-col md:flex-row items-center relative overflow-hidden">
        <!-- Stars and sparkles for game effect -->
        <div class="absolute top-2 left-2 text-yellow-400 text-2xl animate-bounce">⭐</div>
        <div class="absolute bottom-4 right-4 text-pink-400 text-xl animate-bounce">⭐</div>

        <!-- Gambar -->
        <div class="w-full md:w-1/2 mb-6 md:mb-0 md:mr-10">
           <img src="{{ asset('storage/welcome/welcome.jpg') }}" alt="Welcome Game"
    class="rounded-xl shadow-lg w-full border-4 border-pink-300">


        </div>

        <!-- Konten -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-extrabold mb-4 text-indigo-800 font-game">GAMIFY QUEST</h1>

            <p class="text-gray-700 mb-6 text-lg font-semibold">Masuk dan mulai petualanganmu sekarang!</p>
            <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                <a href="{{ route('login') }}"
                    class="bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 shadow-lg transform hover:scale-105 transition-all duration-300">🔐
                    Login</a>
                <a href="{{ route('register') }}"
                    class="bg-yellow-400 text-gray-900 px-6 py-3 rounded-xl hover:bg-yellow-500 shadow-lg transform hover:scale-105 transition-all duration-300">📝
                    Register</a>
            </div>
        </div>
    </div>

</body>

</html>