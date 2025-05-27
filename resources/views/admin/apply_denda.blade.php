@extends('layouts.app')

@section('content')
<form action="{{ route('admin.pengembalian.applyDenda', $pengembalian->id) }}" method="POST">
    @csrf
    <label for="denda_id">Pilih Denda:</label>
    <select name="denda_id" id="denda_id" required>
        @foreach ($dendas as $denda)
            <option value="{{ $denda->id }}">{{ $denda->name }} (Rp{{ number_format($denda->nominal, 0, ',', '.') }})</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary mt-2">Apply Denda</button>
</form>

@endsection