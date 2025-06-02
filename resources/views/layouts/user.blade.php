<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .gradient-bg {
            background-color: #ffffff;
        }
    </style>
</head>
<body>
    <nav class="navbar gradient-bg text-sky-900 py-4 shadow-lg relative">
    <div class="container mx-auto flex justify-between items-center px-6">
        <a href="{{ route('user.home') }}" class="flex items-center">
            <img src="{{ url('logotb.png') }}" alt="Logo" class="w-12 h-15 mr-2">
            <span class="text-lg font-bold">Sistem Informasi <br> Sarana & Prasarana</span>
        </a>
        <ul class="flex gap-4">
            <li><a href="{{ route('user.home') }}" class="nav-link hover:text-gray-300">Home</a></li>
            <li><a href="{{ route('user.barang') }}" class="nav-link hover:text-gray-300">Barang</a></li>
            <li><a href="{{ route('user.peminjaman.riwayat') }}" class="nav-link hover:text-gray-300">Peminjaman</a></li>
           
        </ul>
        <div class="relative" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                @auth
                    <span>{{ auth()->user()->name }}</span>
                @endauth
                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200 transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div
                x-show="open"
                x-transition
                class="absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50 text-black"
            >   
                <a href="{{ route('user.tentang_kami') }}" class="block px-4 py-2 hover:bg-gray-200">Tentang Kami</a>
                <a href="{{ route('user.hubungi-kami') }}" class="block px-4 py-2 hover:bg-gray-200">Hubungi Kami</a>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-full text-left bg-blue-600 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-4 py-2 bg-blue-600 hover:bg-red-600 text-white font-bold rounded text-center">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

    <div id="content" class="container mx-auto p-4">
        @yield('content')
        
    </div>

    
    <footer class="bg-gray-800 text-white p-4 text-center bottom-0 left-0 right-0">
        <p>&copy; 2025 Sisfo Sarpras. All rights reserved.</p>
    </footer>

    <script>
        $(document).ready(function() {

            $('#dropdown-profile').click(function(event) {
                event.stopPropagation();
                $('#dropdown-menu').toggleClass('hidden');
            });

            $(document).click(function(event) {
                if (!event.target.closest('#dropdown-profile')) {
                    $('#dropdown-menu').addClass('hidden');
                }
            });
        });
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @yield('scripts')
</body>
</html>
