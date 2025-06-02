@extends('layout/owner-nav')

@section('content')
<div class="card-header pb-0">
    <h6>Tabel Mobil</h6>
</div>
<div class="container mt-5">        
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Tahun</th>
                        <th>Tipe</th>
                        <th>TNKB</th>
                        <th>Kapasitas</th>
                        <th>Transmisi</th>
                        <th>BBM</th>
                        <th>Harga Sewa</th>
                        <th>Status</th>
                    </tr>   
                </thead>
                <tbody>
                    @foreach ($mobil as $mobil)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($mobil->gambar)
                                <img src="{{ asset('storage/' . $mobil->gambar) }}" width="150" alt="Gambar Mobil">
                            @else
                                <small>Tidak ada gambar</small>
                            @endif
                        </td>
                        <td>{{ $mobil->nama }}</td>
                        <td>{{ $mobil->tahun }}</td>
                        <td>{{ $mobil->tipe ?? '-' }}</td>
                        <td>{{ $mobil->tnkb }}</td>
                        <td>{{ $mobil->kapasitas ?? '-' }}</td>
                        <td>{{ $mobil->transmisi ?? '-' }}</td>
                        <td>{{ $mobil->bbm ?? '-' }}</td>
                        <td>Rp {{ number_format($mobil->hargasewa, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                $mobil->status == 'Maintenance' ? 'warning' : 
                                ($mobil->status == 'Disewa' ? 'danger' : 
                                ($mobil->status == 'Tersedia' ? 'success' : 'secondary')) }}">
                                {{ $mobil->status }}
                            </span>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
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