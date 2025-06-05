@extends('layouts.app')



@section('content')
<h4 class="text-lg font-bold">Welcome.. {{ Auth::user()->name }}</h4> 
<h1 class="text-3xl font-bold mb-4">Dashboard</h1>

{{-- Dashboard Statistics --}}
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-blue-500 text-white rounded-lg p-4 shadow">
        <h2 class="text-xl font-bold">{{ $barangCount}}</h2>
        <p>Barang</p>
    </div>
    <div class="bg-green-500 text-white rounded-lg p-4 shadow">
        <h2 class="text-xl font-bold">{{ $peminjamanCount ?? 0 }}</h2>
        <p>Peminjaman</p>
    </div>
    <div class="bg-yellow-500 text-white rounded-lg p-4 shadow">
        <h2 class="text-xl font-bold">{{ $pengembalianCount ?? 0 }}</h2>
        <p>Pengembalian</p>
    </div>
    <div class="bg-red-500 text-white rounded-lg p-4 shadow">
        <h2 class="text-xl font-bold">{{ $kategoriCount}}</h2>
        <p>Kategori</p>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">Statistik Peminjaman per Bulan</h2>
        <canvas id="peminjamanChart" height="100"></canvas>
    </div>    
</div>


<br><br>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('peminjamanChart').getContext('2d');
    const peminjamanChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($peminjamanPerMonth),
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0
                }
            }
        }
    });
</script>
@endpush