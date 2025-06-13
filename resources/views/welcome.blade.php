<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-pink-100 via-yellow-100 to-red-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-10 rounded-3xl shadow-lg max-w-4xl w-full flex flex-col md:flex-row items-center">
        <!-- Gambar -->
        <div class="w-full md:w-1/2 mb-6 md:mb-0 md:mr-8">
            <img src="https://source.unsplash.com/600x400/?education,learning" alt="Welcome Image"
                class="rounded-xl shadow-md w-full">
        </div>

        <!-- Konten -->
        <div class="w-full md:w-1/2 text-center md:text-left">
            <h1 class="text-4xl font-bold mb-4 text-gray-800">Selamat Datang!</h1>
            <p class="text-gray-600 mb-6">Silakan login atau daftar untuk memulai.</p>
            <div class="flex flex-col sm:flex-row justify-center md:justify-start gap-4">
                <a href="{{ route('login') }}"
                    class="bg-blue-500 text-white px-6 py-3 rounded-xl hover:bg-blue-600 transition">Login</a>
                <a href="{{ route('register') }}"
                    class="bg-gray-200 text-gray-800 px-6 py-3 rounded-xl hover:bg-gray-300 transition">Register</a>
            </div>

        </div>
    </div>
</body>

</html>