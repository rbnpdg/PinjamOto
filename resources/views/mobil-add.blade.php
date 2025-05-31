@extends('layout/admin-nav')

@section('content')
<h2 class="mt-5 mb-4 text-center">Tambah Mobil</h2>
<div class="d-flex justify-content-center ml-4 mr-4">
    <form action="{{ route('mobil-store') }}" class="mb-4" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mobil</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" class="form-control" min="2000" max="2099" required>
        </div>

        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe</label>
            <select name="tipe" class="form-control">
                <option value="">-- Pilih Tipe --</option>
                <option value="Mpv">MPV</option>
                <option value="SUV">SUV</option>
                <option value="Sedan">Sedan</option>
                <option value="City car">City Car</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tnkb" class="form-label">TNKB</label>
            <input type="text" name="tnkb" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas Penumpang</label>
            <input type="number" name="kapasitas" class="form-control">
        </div>

        <div class="mb-3">
            <label for="transmisi" class="form-label">Transmisi</label>
            <select name="transmisi" class="form-control">
                <option value="">-- Pilih Transmisi --</option>
                <option value="Manual">Manual</option>
                <option value="Otomatis">Otomatis</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="bbm" class="form-label">Bahan Bakar</label>
            <select name="bbm" class="form-control">
                <option value="">-- Pilih BBM --</option>
                <option value="Bensin">Bensin</option>
                <option value="Diesel">Diesel</option>
                <option value="Listrik">Listrik</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="hargasewa" class="form-label">Harga Sewa</label>
            <input type="number" name="hargasewa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Tersedia">Tersedia</option>
                <option value="Disewa">Disewa</option>
                <option value="Maintenance">Maintenance</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Mobil</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

        @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Tutup'
            });
        </script>
        @endif
</div>
@endsection