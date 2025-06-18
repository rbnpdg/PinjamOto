@extends('layout/user-nav')

@section('title', 'Bayar Transaksi')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card w-50 shadow p-4">
        <h3 class="text-primary mb-4">Preview Transaksi</h3>

        <table class="table table-borderless">
            <tr><th style="width: 40%;">Nama Pemesan</th><td>{{ $user->nama }}</td></tr>
            <tr><th>No. Telepon</th><td>{{ $user->telepon }}</td></tr>
            <tr><th>Alamat</th><td>{{ $user->alamat }}</td></tr>
            <tr><th>Mobil</th><td>{{ $mobil->nama }} - {{ $mobil->tnkb }}</td></tr>
            <tr><th>Tanggal Sewa</th>
                <td><b class="text-success">{{ date('d-m-Y', strtotime($tanggal_mulai)) }}</b> hingga 
                    <b class="text-success">{{ date('d-m-Y', strtotime($tanggal_selesai)) }}</b></td></tr>
            <tr><th>Durasi</th><td>{{ $durasi }} hari</td></tr>
            <tr><th>Harga per Hari</th><td>Rp {{ number_format($mobil->hargasewa, 0, ',', '.') }},-</td></tr>
            <tr><th>Total Biaya</th><td class="text-success fw-bold">Rp {{ number_format($total, 0, ',', '.') }},-</td></tr>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('mobil-katalog') }}" class="btn btn-outline-danger">Batal</a>
            <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
        </div>
    </div>
</div>

<!-- Midtrans Snap.js -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function (result) {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Berhasil',
                    text: 'Transaksi Anda telah berhasil dilakukan.',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = "/katalog"; // halaman khusus sukses
                });
            },
            onPending: function (result) {
                Swal.fire({
                    icon: 'info',
                    title: 'Menunggu Pembayaran',
                    text: 'Silakan selesaikan pembayaran Anda.',
                    confirmButtonText: 'OK'
                });
            },
            onError: function (result) {
                Swal.fire({
                    icon: 'error',
                    title: 'Pembayaran Gagal',
                    text: 'Terjadi kesalahan saat memproses pembayaran.',
                    confirmButtonText: 'OK'
                });
            },
            onClose: function () {
                Swal.fire({
                    icon: 'warning',
                    title: 'Dibatalkan',
                    text: 'Anda menutup pembayaran sebelum selesai.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endsection
