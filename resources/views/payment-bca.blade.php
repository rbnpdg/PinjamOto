@extends('layout/user-nav')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card w-50 shadow p-4">
        <h3 class="text-primary mb-4">Pembayaran via BCA</h3>

        <table class="table table-borderless mb-4">
            <tr><th style="width: 40%;">Nama Pemesan</th><td>{{ $user->nama }}</td></tr>
            <tr><th>No. Telepon</th><td>{{ $user->telepon }}</td></tr>
            <tr><th>Mobil</th><td>{{ $mobil->nama }} - {{ $mobil->tnkb }}</td></tr>
            <tr><th>Tanggal Sewa</th>
                <td><b class="text-success">{{ date('d-m-Y', strtotime($tanggal_mulai)) }}</b> hingga 
                    <b class="text-success">{{ date('d-m-Y', strtotime($tanggal_selesai)) }}</b></td></tr>
            <tr><th>Total Biaya</th><td class="text-success fw-bold">Rp {{ number_format($total_biaya, 0, ',', '.') }},-</td></tr>
        </table>

        <div class="text-center">
            <p class="mb-2">Silakan scan kode QR di bawah untuk melakukan pembayaran:</p>
            <img src="{{ asset('images/qris.png') }}" alt="QRIS" style="max-width: 200px;">
        </div>
    </div>
</div>
@endsection
