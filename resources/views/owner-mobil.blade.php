@extends('layout/owner-nav')

@section('content')
<div class="card-header pb-0">
    <h3>Tabel Mobil</h3>
</div>

<form method="GET" action="{{ route('mobil-owner') }}" class="row g-2 mb-4 me-2 justify-content-end">
    <div class="col-md-1">
        <select name="merk" class="form-select">
            <option value="">Merk</option>
            @php
                $merkList = ['Toyota', 'Isuzu', 'Mazda', 'Mitsubishi']; // sesuaikan jika ada merk lain
            @endphp
            @foreach ($merkList as $merk)
                <option value="{{ strtolower($merk) }}" {{ request('merk') == strtolower($merk) ? 'selected' : '' }}>
                    {{ $merk }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-1">
        <select name="tipe" class="form-select">
            <option value="">Jenis</option>
            @foreach (['Mpv', 'SUV', 'Sedan', 'City car'] as $tipe)
                <option value="{{ $tipe }}" {{ request('tipe') == $tipe ? 'selected' : '' }}>
                    {{ $tipe }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-1">
        <select name="bbm" class="form-select">
            <option value="">BBM</option>
            @foreach (['Bensin', 'Diesel', 'Listrik'] as $bbm)
                <option value="{{ $bbm }}" {{ request('bbm') == $bbm ? 'selected' : '' }}>
                    {{ $bbm }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-1">
        <select name="tahun" class="form-select">
            <option value="">Tahun</option>
            <option value="2010-2015" {{ request('tahun') == '2010-2015' ? 'selected' : '' }}>2010 - 2015</option>
            <option value="2016-2020" {{ request('tahun') == '2016-2020' ? 'selected' : '' }}>2016 - 2020</option>
            <option value="2021-2025" {{ request('tahun') == '2021-2025' ? 'selected' : '' }}>2021 - 2025</option>
        </select>
    </div>

    <div class="col-md-1">
        <select name="status" class="form-select">
            <option value="">Status</option>
            @foreach (['Tersedia', 'Disewa', 'Maintenance'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <input type="text" name="search" class="form-control" placeholder="Cari Nama / TNKB" value="{{ request('search') }}">
    </div>

    <div class="col-md-1 d-grid">
        <button class="btn btn-primary" type="submit">Filter</button>
    </div>

    <div class="col-md-1 d-grid">
        <a class="btn btn-outline-danger" href="{{ route('mobil-owner') }}">Reset</a>
    </div>
</form>

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
                        <td class="text-center">{{ $loop->iteration }}</td>
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