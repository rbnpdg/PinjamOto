@extends('layout/user-nav')

@section('content')
<div class="container d-flex justify-content-center align-items-center py-5">
    <div class="card w-50 shadow p-4">
        <h3 class="text-primary mb-4">Preview Transaksi</h3>

        <table class="table table-borderless">
            <tr><th style="width: 40%;">Nama Pemesan</th><td>{{ $user->nama }}</td></tr>
            <tr><th>No. Telepon</th><td>{{ $user->telepon }}</td></tr>
            <tr><th>Alamat</th><td>{{ $user->alamat }}</td></tr>
            <tr><th>Mobil</th><td>{{ $mobil->nama }} - {{ $mobil->tnkb }}</td></tr>
            <tr><th>Tanggal Sewa</th>
                <td><b class="text-success">{{ date('d-m-Y', strtotime($tanggal_mulai)) }}</b> hingga 
                    <b class="text-success">{{ date('d-m-Y', strtotime($tanggal_selesai)) }}</b></td></tr>
            <tr><th>Durasi</th><td>{{ $durasi }} hari</td></tr>
            <tr><th>Harga per Hari</th><td>Rp {{ number_format($mobil->hargasewa, 0, ',', '.') }},-</td></tr>
            <tr><th>Total Biaya</th><td class="text-success fw-bold">Rp {{ number_format($total, 0, ',', '.') }},-</td></tr>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('mobil-katalog') }}" class="btn btn-outline-danger">Batal</a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#paymentModal">
                Bayar Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Payment modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="paymentModalLabel">Pilih Metode Pembayaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div id="payment-options">
          @php
              $methods = ['qris', 'gopay', 'bni', 'bca', 'cod'];
          @endphp

          @foreach ($methods as $method)
          <div class="border rounded px-3 py-2 mb-2 d-flex align-items-center method-option" data-method="{{ $method }}" style="cursor: pointer;">
              <input class="form-check-input me-2" type="radio" name="metode_pembayaran" value="{{ $method }}" style="display: none;">
              <img src="{{ asset('img/' . $method . '.png') }}" alt="{{ strtoupper($method) }}" style="width: 30px;" class="me-2">
              <span>{{ strtoupper($method) }}</span>
          </div>
          @endforeach
        </div>

        <div class="mt-3 text-center">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const methodOptions = document.querySelectorAll(".method-option");

    methodOptions.forEach(option => {
      option.addEventListener("click", function () {
        const selectedMethod = this.dataset.method;

        // Redirect ke route pembayaran dengan parameter transaksi
        const params = new URLSearchParams({
          user_id: "{{ $user->id }}",
          mobil_id: "{{ $mobil->id }}",
          tanggal_mulai: "{{ $tanggal_mulai }}",
          tanggal_selesai: "{{ $tanggal_selesai }}",
          total_biaya: "{{ $total }}"
        });

        window.location.href = `/bayar/${selectedMethod}?${params.toString()}`;
      });
    });
  });
</script>
@endsection
