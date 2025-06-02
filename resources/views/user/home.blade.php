@extends('layout.user-nav')

@section('title', 'Beranda')

@section('content')
<div class="hero">
    <div class="hero-text text-center">
        <h1 class="display-4 fw-bold">Sewa Mobil Mudah & Cepat</h1>
        <p class="lead">Temukan mobil terbaik untuk perjalanan Anda hanya di PinjamOTO</p>
        <a href="{{ route('cars') }}" class="btn btn-light fw-semibold px-4">Lihat Mobil</a>
    </div>
</div>

{{-- Section About Us --}}
<div class="container mt-5 d-flex align-items-center">
    <div class="me-4">
        <img src="{{ asset('img/camryrmv.png') }}" alt="Jeep" class="img-fluid" style="max-width: 400px;">
    </div>
    <div>
        <h2 class="fw-bold">Tentang <span class="text-danger">Kami</span></h2>
        <p style="font-size: 14px;">
            Going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text.
            All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary.
        </p>
        <a href="{{ route('cars') }}" class="btn btn-danger">Read More</a>
    </div>
</div>

{{-- Section Our Best Offers --}}
<div class="container mt-5 text-center">
    <h2 class="fw-bold mb-4">Saran Kami</h2>
    <div class="row">
        @for ($i = 0; $i < 6; $i++)
        <div class="col-md-4 mb-4">
            <div class="card p-3">
                <img src="{{ asset('images/car.png') }}" class="card-img-top img-fluid" alt="Toyota Car">
                <div class="card-body">
                    <h5 class="card-title">TOYOTA CAR</h5>
                    <p class="card-text">Start per day $4500</p>
                    <a href="#" class="btn btn-danger">Book Now</a>
                </div>
            </div>
        </div>
        @endfor
    </div>
</div>

<div class="container mt-5 text-center">
    <h2 class="fw-bold">Kenapa Pilih <span class="text-danger">Kami?</span></h2>
    <div class="row">
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
@endsection
