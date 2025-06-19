@extends('layout/admin-nav')

@section('content')
<div class="container mt-4">
    <h2>Tambah Transaksi Baru</h2>
    
    <form action="{{ route('admin-trpreview') }}" method="POST">
        @csrf

        {{-- Konsumen --}}
        <div class="mb-3">  
            <label for="user_id" class="form-label">Pilih Konsumen</label>
            <select name="user_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Konsumen --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->nama }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        {{-- Mobil --}}
        <div class="mb-3">
            <label for="mobil_id" class="form-label">Pilih Mobil</label>
            <select name="mobil_id" id="mobil_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Mobil --</option>
                @foreach($mobils as $mobil)
                    <option value="{{ $mobil->id }}" data-harga="{{ $mobil->harga_per_hari ?? 0 }}">
                        {{ $mobil->nama }} - {{ $mobil->tnkb }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Tanggal Mulai --}}
        <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>

        {{-- Tanggal Selesai --}}
        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" min="{{ date('Y-m-d') }}" required>
        </div>

        {{-- Metode Pembayaran --}}
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-select" required>
                <option value="" disabled selected>-- Pilih Metode Pembayaran --</option>
                <option value="gopay">Gopay</option>
                <option value="qris">QRIS</option>
                <option value="bca">Transfer BCA</option>
                <option value="bni">Transfer BNI</option>
                <option value="cod">Tunai</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
    </form>

    {{-- Validasi tanggal pakai JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const mulai = document.querySelector('input[name="tanggal_mulai"]');
            const selesai = document.querySelector('input[name="tanggal_selesai"]');

            form.addEventListener('submit', function (e) {
                const today = new Date();
                today.setHours(0, 0, 0, 0); // Set ke awal hari

                const tglMulai = new Date(mulai.value);
                const tglSelesai = new Date(selesai.value);

                if (tglMulai < today) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal tidak valid',
                        text: 'Tanggal mulai minimal adalah hari ini.',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                if (tglSelesai <= tglMulai) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tanggal tidak valid',
                        text: 'Tanggal selesai harus setelah tanggal mulai.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>

    {{-- Tampilkan error jika ada --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonText: 'Tutup'
                });
            });
        </script>
    @endif
</div>
@endsection
