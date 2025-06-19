@extends('layout/user-nav')

@section('title', 'Beranda')

@section('content')

{{-- Section Hero --}}
<div class="hero" style="background-color: #fff;">
    <div class="hero-text text-center">
        <h1 class="display-4 fw-bold">Sewa Mobil Mudah & Cepat</h1>
        <p class="lead">Temukan mobil terbaik untuk perjalanan Anda hanya di PinjamOTO</p>
        <a href="{{ route('mobil-katalog') }}" class="btn btn-light px-4"><b>Lihat Mobil</b></a>
    </div>
</div>

{{-- Section About Us --}}
<div class="container-fluid py-5" style="background-color: #f2f2f2;">
    <div class="container d-flex align-items-center">
        <div class="me-4">
            <img src="{{ asset('img/camryrmv.png') }}" alt="Jeep" class="img-fluid" style="max-width: 400px;">
        </div>
        <div>
            <h2 class="fw-bold">Tentang <span class="text-danger">Kami</span></h2>
            <p style="font-size: 14px;">
                PinjamOTO merupakan platform penyewaan mobil terpercaya yang menghadirkan berbagai pilihan kendaraan berkualitas dengan proses cepat, aman, dan mudah. Dengan pelayanan profesional dan harga kompetitif, kami siap mendukung kebutuhan mobilitas Anda, baik untuk perjalanan harian, liburan, maupun urusan bisnis.
            </p>
        </div>
    </div>
</div>


{{-- Section Why Choose Us --}}
<div class="container-fluid py-5" style="background-color: #ffffff;">
    <div class="container text-center">
        <h2 class="fw-bold">Kenapa Pilih <span class="text-danger">Kami?</span></h2>
        <div class="row mt-5">
            <div class="col-md-4">
                <i class="bi bi-clock-history fs-1 text-danger"></i>
                <h5 class="mt-2">Cepat & Praktis</h5>
                <p>Proses pemesanan mobil hanya dalam hitungan menit.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-shield-check fs-1 text-danger"></i>
                <h5 class="mt-2">Aman & Terpercaya</h5>
                <p>Mobil dirawat rutin dan asuransi tersedia.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-car-front-fill fs-1 text-danger"></i>
                <h5 class="mt-2">Beragam Pilihan</h5>
                <p>Tersedia berbagai jenis mobil sesuai kebutuhan Anda.</p>
            </div>
        </div>
    </div>
</div>

{{-- Success Alert --}}
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>

@endsection
