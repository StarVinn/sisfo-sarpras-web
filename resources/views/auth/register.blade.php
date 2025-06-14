<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('{{ asset('tb.jpg') }}');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left side with logo and title -->
    <div class="w-1/2 flex flex-col justify-center items-start bg-white bg-opacity-0 p-10">
        <h1 class="text-4xl font-bold text-white text-left">Sistem Informasi <br> Sarana & Prasarana</h1>
    </div>

    <!-- Right side with register form -->
    <div class="w-1/2 flex justify-end items-center opacity-70">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            <img src="{{ asset('logotb.png') }}" alt="Logo" class="mx-auto mb-6 w-40 h-auto opacity-70" />
            <h2 class="text-2xl font-bold text-center text-sky-500 mb-4">Register</h2>
            @if ($errors->any())
                <div class="text-red-500 mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-1">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" />
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" />
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                    <input type="password" id="password" name="password" value="{{ old('password') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" />
                </div>
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" />
                </div>
                <button type="submit"
                    class="w-full bg-sky-900 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-300">
                    Register
                </button>
            </form>
            <p class="text-center text-sm text-gray-500 mt-4">
                <a href="{{ route('admin.user.index') }}" class="text-sky-700 font-semibold hover:underline">Kembali</a>
            </p>
        </div>
    </div>
</body>
</html>
