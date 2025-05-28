<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
</head>
<body>
    <nav class="bg-sky-500 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img class="w-15 h-20" src="{{ url('logotb.png') }}" alt="Logo">
                <span class="font-bold text-lg">Sistem Informasi <br> Sarana & Prasarana</span>
            </div>
            <div class="flex items-center space-x-4">
                
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
        </div>
    </nav>

    <div class="flex min-h-screen">
        <aside class="w-64 bg-neutral-700 text-white p-6" x-data="{ laporanOpen: false }">
            <nav class="space-y-4">
                <a href="{{ route('admin.index') }}" class="block px-4 py-2 rounded hover:bg-blue-900">Dashboard</a>
                <a href="{{ route('admin.barang.index') }}" class="block px-4 py-2 rounded hover:bg-blue-900">Barang</a>
                <a href="{{ route('admin.category.index') }}" class="block px-4 py-2 rounded hover:bg-blue-900">Kategori</a>
                <a href="{{ route('admin.peminjaman.index') }}" class="block px-4 py-2 rounded hover:bg-blue-900">Peminjaman</a>
                <a href="{{ route('admin.denda.index') }}" class="block px-4 py-2 rounded hover:bg-blue-900">Denda</a>

                <!-- Dropdown Laporan -->
                <div>
                    <button @click="laporanOpen = !laporanOpen" class="w-full flex justify-between items-center px-4 py-2 rounded hover:bg-blue-900 focus:outline-none">
                        <span>Laporan</span>
                        <svg :class="{ 'rotate-180': laporanOpen }" class="w-4 h-4 transition-transform duration-200 transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div x-show="laporanOpen" x-transition class="mt-1 space-y-1 pl-4">
                        <a href="{{ route('admin.barang.export') }}" class="block px-4 py-2 rounded hover:bg-blue-800">Laporan Barang</a>
                        <a href="{{ route('admin.category.export') }}" class="block px-4 py-2 rounded hover:bg-blue-800">Laporan Kategori</a>
                        <a href="{{ route('admin.peminjaman.export') }}" class="block px-4 py-2 rounded hover:bg-blue-800">Laporan Peminjaman</a>
                        {{-- <a href="{{ route('admin.user.export') }}" class="block px-4 py-2 rounded hover:bg-blue-800">Laporan Akun User</a> --}}
                    </div>
                </div>
            </nav>
        </aside>

        <main class="flex-1 container mx-auto p-4">
            @yield('content')
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>
