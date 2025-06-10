@extends('layout/user-nav')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card w-50 shadow p-4">
        <h3 class="text-primary mb-2 text-center"><b>Konfirmasi Transaksi</b></h3><hr>

        <table class="table table-borderless mb-4">
            <tr><th style="width: 40%;">Nama Pemesan</th><td>{{ $user->nama }}</td></tr>
            <tr><th>No. Telepon</th><td>{{ $user->telepon }}</td></tr>
            <tr><th>Mobil</th><td>{{ $mobil->nama }} - {{ $mobil->tnkb }}</td></tr>
            <tr>
                <th>Tanggal Sewa</th>
                <td>
                    <b class="text-success">{{ date('d-m-Y', strtotime($tanggal_mulai)) }}</b> hingga 
                    <b class="text-success">{{ date('d-m-Y', strtotime($tanggal_selesai)) }}</b>
                </td>
            </tr>
            <tr><th>Total Biaya</th><td class="text-success fw-bold">Rp {{ number_format($total_biaya, 0, ',', '.') }},-</td></tr>
        </table><hr>

        <p class="text-center">Apakah transaksi Anda sudah sesuai?</p>

        <div class="text-center">

            <form id="formBayar" action="{{ route('transaksi.konfirmasiBayar') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="mobil_id" value="{{ $mobil->id }}">
                <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
                <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
                <input type="hidden" name="total_biaya" value="{{ $total_biaya }}">
                <input type="hidden" name="metode_pembayaran" value="gopay">

                <div class="d-flex justify-content-center gap-3 mt-3">
                    <a href="{{ route('mobil-katalog') }}" class="btn btn-outline-danger">Batal</a>
                    <button type="submit" class="btn btn-success">Buat Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
