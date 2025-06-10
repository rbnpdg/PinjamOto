@extends('layout/user-nav')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card w-50 shadow p-4">
        <h3 class="text-primary mb-4">Pembayaran BNI</h3>

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
        </table>

        <div class="text-center">
            <p class="mb-2">Silahkan transfer ke rekening berikut sejumlah <b>Rp {{ number_format($total_biaya, 0, ',', '.') }},-</b></p>
            
            <div class="input-group mb-3 justify-content-center">
                <input type="text" class="form-control text-center" id="rekening" value="182788478" readonly style="max-width: 200px;">
                <button class="btn btn-outline-primary" onclick="salinRekening()">
                    <i class="fas fa-copy"></i>
                </button>
            </div>

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
                    <button type="submit" class="btn btn-success">Saya Sudah Bayar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function salinRekening() {
        const rekening = document.getElementById("rekening").value;
        navigator.clipboard.writeText(rekening).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'Disalin!',
                text: 'Nomor rekening berhasil disalin.',
                timer: 900,
                showConfirmButton: false
            });
        }).catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Gagal menyalin nomor rekening.',
            });
        });
    }
</script>
@endsection
