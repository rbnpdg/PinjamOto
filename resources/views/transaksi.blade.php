@extends('layout/admin-nav')

@section('content')
<div class="card-header pb-0">
    <h6>Tabel Transaksi</h6>
</div>

<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h2>Data Transaksi</h2>
        <a href="{{ route('transaksi-add') }}" class="btn btn-primary py-2">Tambah Transaksi</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Konsumen</th>
                    <th>Mobil</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Biaya</th>
                    <th>Bukti Pembayaran</th>
                    <th>Status Transaksi</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $transaksi->user->nama ?? '-' }} ({{ $transaksi->user->email ?? '-' }})</td>
                        <td>{{ $transaksi->mobil->nama ?? '-' }} - {{ $transaksi->mobil->tnkb ?? '-' }}</td>
                        <td>{{ $transaksi->tanggal_mulai }}</td>
                        <td>{{ $transaksi->tanggal_selesai }}</td>
                        <td>Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
                        <td>
                            @if ($transaksi->bukti_tf)
                                <!-- Tombol untuk membuka modal -->
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalBukti{{ $transaksi->id }}">
                                    Lihat
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalBukti{{ $transaksi->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $transaksi->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel{{ $transaksi->id }}">Bukti Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('bukti_tf/' . $transaksi->bukti_tf) }}" alt="Bukti Transfer" class="img-fluid d-block mx-auto mb-3">
                                                <button type="button" class="btn btn-outline-danger d-block mx-auto" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <small>Tidak ada gambar</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ 
                                $transaksi->status == 'Berjalan' ? 'warning' : 
                                ($transaksi->status == 'Dibatalkan' ? 'danger' : 
                                ($transaksi->status == 'Selesai' ? 'success' : 'secondary')) }}">
                                {{ $transaksi->status }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ 
                                $transaksi->status_payment == 'Dibayar' ? 'success' : 
                                ($transaksi->status_payment == 'Menunggu' ? 'secondary' : 
                                ($transaksi->status_payment == 'Ditolak' ? 'danger' : 'dark')) }}">
                                {{ $transaksi->status_payment ?? 'Tidak Diketahui' }}
                            </span>
                        </td>
                        <td>
                            @if ($transaksi->status_payment == 'Menunggu')
                                <form action="{{ route('transaksi-konfirmasi', $transaksi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary btn-sm">Konfirmasi Transaksi</button>
                                </form>

                                <form action="{{ route('transaksi-tolak', $transaksi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Tolak Transaksi</button>
                                </form>
                            @endif

                            @if ($transaksi->status == 'Berjalan')
                                <!-- <form action="{{ route('transaksi-reject', $transaksi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                                </form> -->

                                <form action="{{ route('transaksi-finish', $transaksi->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>
@endif
