@extends('layout/owner-nav')

@section('content')
<div class="container mt-4">
  <h2>Dashboard Owner</h2>
  <div class="row mt-4 g-4 pb-4">

    <!-- Card Jumlah Mobil -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0" style="border-radius: 0.75rem;">
        <div class="card-body d-flex align-items-center">
          <div class="icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px; height:60px;">
            <i class="fa-solid fa-car-rear" style="font-size: 27px; color: #fff;"></i>
          </div>
          <div>
            <h6 class="card-subtitle mb-1 text-muted">Jumlah Mobil</h6>
            <h3 class="card-title mb-0">{{ $jumlahMobil }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Card Jumlah Konsumen -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0" style="border-radius: 0.75rem;">
        <div class="card-body d-flex align-items-center">
          <div class="icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px; height:60px;">
            <i class="fa-solid fa-users" style="font-size: 27px; color: #fff;"></i>
          </div>
          <div>
            <h6 class="card-subtitle mb-1 text-muted">Jumlah Konsumen</h6>
            <h3 class="card-title mb-0">{{ $jumlahUser }}</h3>
          </div>
        </div>
      </div>
    </div>

    <!-- Card Jumlah Transaksi -->
    <div class="col-md-4">
      <div class="card shadow-sm border-0" style="border-radius: 0.75rem;">
        <div class="card-body d-flex align-items-center">
          <div class="icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:60px; height:60px;">
            <i class="fa-solid fa-receipt" style="font-size: 27px; color: #fff;"></i>
          </div>
          <div>
            <h6 class="card-subtitle mb-1 text-muted">Jumlah Transaksi</h6>
            <h3 class="card-title mb-0">{{ $jumlahTransaksi }}</h3>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
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
@endsection
