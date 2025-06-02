@extends('layout/owner-nav')

@section('content')
<div class="card-header pb-0">
    <h6>Tabel Transaksi</h6>
</div>

<div class="container mt-5">
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
                    <th>Status</th>
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
                            <span class="badge bg-{{ 
                                $transaksi->status == 'Berjalan' ? 'warning' : 
                                ($transaksi->status == 'Dibatalkan' ? 'danger' : 
                                ($transaksi->status == 'Selesai' ? 'success' : 'secondary')) }}">
                                {{ $transaksi->status }}
                            </span>
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
