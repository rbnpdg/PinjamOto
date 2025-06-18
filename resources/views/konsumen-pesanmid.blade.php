@extends('layout/user-nav')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card w-50 w-md-75 p-4 shadow">
        <h2 class="mb-4 text-center text-primary">Pesan Mobil</h2>
        
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            {{-- Nama Konsumen --}}
            <div class="mb-3">
                <label class="form-label">Nama Pemesan</label>
                <input type="text" class="form-control" value="{{ auth()->user()->nama }}" readonly>
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            </div>

            {{-- Nama Mobil --}}
            <div class="mb-3">
                <label class="form-label">Mobil yang Dipesan</label>
                <input type="text" class="form-control" value="{{ $mobil->nama }} - {{ $mobil->tnkb }}" readonly>
                <input type="hidden" name="mobil_id" value="{{ $mobil->id }}">
            </div>

            {{-- Tanggal Mulai --}}
            <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" required>
            </div>

            {{-- Tanggal Selesai --}}
            <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('mobil-katalog') }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
            </div>
        </form>
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
</div>
@endsection
