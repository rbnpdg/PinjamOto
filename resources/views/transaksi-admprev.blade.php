@extends('layout/admin-nav')

@section('content')
<div class="container mt-4">
    <div class="card shadow p-4">
        <h3 class="text-primary mb-4">Preview Transaksi</h3>

        <table class="table table-borderless">
            <tr>
                <th width="30%">Nama Konsumen</th>
                <td>{{ $user->name }} {{ $user->nama }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <th>Mobil</th>
                <td>{{ $mobil->nama }} - {{ $mobil->tnkb }}</td>
            </tr>
            <tr>
                <th>Tanggal Sewa</th>
                <td><b class="text-success">{{ date('d-m-Y', strtotime($tanggal_mulai)) }}</b> hingga 
                    <b class="text-success">{{ date('d-m-Y', strtotime($tanggal_selesai)) }}</b></td>
            </tr>
            <tr>
                <th>Total Biaya</th>
                <td class="text-success fw-bold">Rp {{ number_format($total_biaya, 0, ',', '.') }},-</td>
            </tr>
            <tr>
                <th>Metode Pembayaran</th>
                <td>
                    <strong>{{ strtoupper($metode_pembayaran) }}</strong><br>

                    @if ($metode_pembayaran === 'gopay')
                        <img src="{{ asset('img/gopay-pay.png') }}" alt="Gopay QR" width="200">
                        <div class="mt-3 mb-2">
                            <a href="{{ asset('img/gopay-pay.png') }}" download="gopay-qr.png" class="btn btn-outline-primary">
                                Download QR
                            </a>
                        </div>
                    @elseif ($metode_pembayaran === 'qris')
                        <img src="{{ asset('img/qris-pay.png') }}" alt="QRIS" width="200">
                        <div class="mt-3 mb-2">
                            <a href="{{ asset('img/qris-pay.png') }}" download="gopay-qr.png" class="btn btn-outline-primary">
                                Download QR
                            </a>
                        </div>
                    @elseif ($metode_pembayaran === 'bca' || $metode_pembayaran === 'bni')
                        <div class="mt-2">
                            <span>Transfer ke No. Rekening:</span><br>
                            <strong>1137857674</strong>
                        </div>
                    @elseif ($metode_pembayaran === 'cod')
                        <span>Pembayaran dilakukan saat serah terima kendaraan.</span>
                    @endif
                </td>
            </tr>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>

            <form action="{{ route('transaksi-store') }}" method="POST">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="mobil_id" value="{{ $mobil->id }}">
                <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
                <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
                <input type="hidden" name="total_biaya" value="{{ $total_biaya }}">
                <input type="hidden" name="metode_pembayaran" value="{{ $metode_pembayaran }}">
                <button type="submit" class="btn btn-success">Konfirmasi Transaksi</button>
            </form>
        </div>
    </div>
</div>
@endsection
