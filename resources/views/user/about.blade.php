@extends('layout.user-nav')

@section('content')
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
@endsection