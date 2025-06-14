@extends('layout/user-nav')

@section('title', 'Histori Transaksi')

@section('content')
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
        <h3 class="fw-bold mb-0">Riwayat Transaksi</h3>
        
        <form method="GET" action="{{ route('filtered-histori') }}" class="d-flex flex-wrap gap-2 align-items-end">
            <div class="flex-grow-1">
                <select name="waktu" class="form-select">
                    <option value="">Waktu</option>
                    <option value="7">Seminggu</option>
                    <option value="15">Setengah Bulan</option>
                    <option value="30">Sebulan</option>
                    <option value="365">Setahun</option>
                </select>
            </div>

            <div class="flex-grow-1">
                <select name="metode" class="form-select">
                    <option value="">Metode</option>
                    <option value="gopay">Gopay</option>
                    <option value="qris">Qris</option>
                    <option value="bni">BNI</option>
                    <option value="bca">BCA</option>
                    <option value="cash">Cash</option>
                </select>
            </div>

            <div class="flex-grow-1">
                <select name="status" class="form-select">
                    <option value="">Status</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Diproses">Diproses</option>
                    <option value="Berjalan">Berjalan</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="flex-grow-1">
                <input type="text" name="search" class="form-control" placeholder="Cari mobil...">
            </div>

            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            <a href="{{ route('histori-show') }}" class="btn btn-outline-danger">Reset</a>
        </form>
    </div>

    @if($transaksis->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada transaksi yang sesuai.
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach ($transaksis as $index => $transaksi)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    {{-- Gambar mobil --}}
                    @if($transaksi->mobil && $transaksi->mobil->gambar)
                        <img src="{{ asset('storage/' . $transaksi->mobil->gambar) }}" 
                            class="card-img-top" 
                            alt="Gambar Mobil {{ $transaksi->mobil->nama }}" 
                            style="height: 200px; object-fit: cover;">
                    @else
                        <img src="{{ asset('img/default-car.jpg') }}" 
                            class="card-img-top" 
                            alt="Gambar Default Mobil" 
                            style="height: 200px; object-fit: cover;">
                    @endif

                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title mb-3">{{ $transaksi->mobil->nama ?? 'Mobil tidak tersedia' }}</h5>

                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between">
                                    <strong>Tanggal</strong>
                                    <span>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between border-bottom-0">
                                    <strong>Status</strong>
                                    <span class="badge bg-{{ 
                                        $transaksi->status == 'Selesai' ? 'success' : 
                                        ($transaksi->status == 'Diproses' ? 'warning' : 
                                        ($transaksi->status == 'Dibatalkan' ? 'danger' : 'dark')) }}">
                                        {{ $transaksi->status ?? 'Tidak Diketahui' }}
                                    </span>
                                </li>
                            </ul>
                        </div>

                        {{-- Tombol Detail --}}
                        <button type="button" class="btn btn-outline-primary w-100 mt-auto" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $index }}">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="modalDetail{{ $index }}" tabindex="-1" aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content" style="min-height: 400px;">
                        <div class="row g-0">
                            {{-- Kolom Gambar Mobil (1/3) --}}
                            <div class="col-md-4 d-flex align-items-center justify-content-center bg-light" style="padding: 0;">
                                @if($transaksi->mobil && $transaksi->mobil->gambar)
                                    <img src="{{ asset('storage/' . $transaksi->mobil->gambar) }}" 
                                        alt="Mobil {{ $transaksi->mobil->nama }}" 
                                        class="img-fluid h-100 w-100 object-fit-cover rounded-start">
                                @else
                                    <img src="{{ asset('img/default-car.jpg') }}" 
                                        alt="Mobil Default" 
                                        class="img-fluid h-100 w-100 object-fit-cover rounded-start">
                                @endif
                            </div>

                            {{-- Kolom Detail (2/3) --}}
                            <div class="col-md-8">
                                <div class="modal-header border-bottom-0">
                                    <h5 class="modal-title" id="modalLabel{{ $index }}">Detail Transaksi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body pt-0">
                                    <table class="w-100">
                                        <tr>
                                            <td class="py-2 fw-semibold" style="width: 40%;">Mobil</td>
                                            <td class="py-2">: {{ $transaksi->mobil->nama ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 fw-semibold">Tanggal Transaksi</td>
                                            <td class="py-2">: {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 fw-semibold">Status</td>
                                            <td class="py-2">: {{ $transaksi->status }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 fw-semibold">Metode Pembayaran</td>
                                            <td class="py-2">: {{ ucfirst($transaksi->metode_pembayaran) }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 fw-semibold">Durasi Sewa</td>
                                            <td class="py-2">: {{ $transaksi->lama_sewa ?? '-' }} hari</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 fw-semibold">Total Harga</td>
                                            <td class="py-2">: Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 fw-semibold">Lokasi Pengambilan</td>
                                            <td class="py-2">: {{ $transaksi->lokasi_pengambilan ?? '-' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="py-2 fw-semibold">Catatan</td>
                                            <td class="py-2">: {{ $transaksi->catatan ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="modal-footer border-top-0">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
    @endif
</div>
@endsection
