@extends('layout/admin-nav')

@section('content')
<div class="container mt-4">
    <div class="card shadow p-4">
        <h3 class="text-primary mb-4">Preview Transaksi</h3>

        <form action="{{ route('transaksi-store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
                                <a href="{{ asset('img/qris-pay.png') }}" download="qris-qr.png" class="btn btn-outline-primary">
                                    Download QR
                                </a>
                            </div>
                        @elseif ($metode_pembayaran === 'bca' || $metode_pembayaran === 'bni')
                            <div class="mt-2">
                                <label for="rekening" class="form-label">Transfer ke No. Rekening:</label>
                                <div class="input-group" style="max-width: 350px;">
                                    <input type="text" class="form-control text-center" id="rekening" value="1137857674" readonly>
                                </div>
                            </div>
                        @elseif ($metode_pembayaran === 'cod')
                            <span>Pembayaran dilakukan saat serah terima kendaraan.</span>
                        @endif

                        {{-- Upload Bukti Transfer (kecuali COD) --}}
                        @if ($metode_pembayaran !== 'cod')
                            <div class="mt-3">
                                <label for="bukti_tf" class="form-label">Upload Bukti Transfer</label>
                                <input type="file" name="bukti_tf" class="form-control" accept="image/*" required>
                                <small class="text-muted">Hanya file gambar (JPG, PNG, JPEG).</small>
                            </div>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Hidden Fields --}}
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="mobil_id" value="{{ $mobil->id }}">
            <input type="hidden" name="tanggal_mulai" value="{{ $tanggal_mulai }}">
            <input type="hidden" name="tanggal_selesai" value="{{ $tanggal_selesai }}">
            <input type="hidden" name="total_biaya" value="{{ $total_biaya }}">
            <input type="hidden" name="metode_pembayaran" value="{{ $metode_pembayaran }}">

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Konfirmasi Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection