@extends('layout/admin-nav')

@section('content')
<h2 class="mb-4 text-center">Edit Mobil</h2>
<div class="d-flex justify-content-center">
@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonText: 'Tutup'
            });
        });
    </script>
@endif


    <form action="{{ route('mobil-update', $mobil->id) }}" method="POST" style="width: 50%;" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mobil</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $mobil->nama) }}" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" id="tahun" min="2000" max="2099" class="form-control" value="{{ old('tahun', $mobil->tahun) }}" required>
        </div>

        <div class="mb-3">
            <label for="tipe" class="form-label">Tipe</label>
            <select name="tipe" class="form-control">
                <option value="">-- Pilih Tipe --</option>
                <option value="Mpv" {{ $mobil->tipe === 'Mpv' ? 'selected' : '' }}>MPV</option>
                <option value="SUV" {{ $mobil->tipe === 'SUV' ? 'selected' : '' }}>SUV</option>
                <option value="Sedan" {{ $mobil->tipe === 'Sedan' ? 'selected' : '' }}>Sedan</option>
                <option value="City car" {{ $mobil->tipe === 'City car' ? 'selected' : '' }}>City Car</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="tnkb" class="form-label">TNKB</label>
            <input type="text" name="tnkb" id="tnkb" class="form-control" value="{{ old('tnkb', $mobil->tnkb) }}" oninput="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="mb-3">
            <label for="kapasitas" class="form-label">Kapasitas Penumpang</label>
            <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $mobil->kapasitas) }}">
        </div>

        <div class="mb-3">
            <label for="transmisi" class="form-label">Transmisi</label>
            <select name="transmisi" class="form-control">
                <option value="">-- Pilih Transmisi --</option>
                <option value="Manual" {{ $mobil->transmisi === 'Manual' ? 'selected' : '' }}>Manual</option>
                <option value="Otomatis" {{ $mobil->transmisi === 'Otomatis' ? 'selected' : '' }}>Otomatis</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="bbm" class="form-label">Bahan Bakar</label>
            <select name="bbm" class="form-control">
                <option value="">-- Pilih BBM --</option>
                <option value="Bensin" {{ $mobil->bbm === 'Bensin' ? 'selected' : '' }}>Bensin</option>
                <option value="Diesel" {{ $mobil->bbm === 'Diesel' ? 'selected' : '' }}>Diesel</option>
                <option value="Listrik" {{ $mobil->bbm === 'Listrik' ? 'selected' : '' }}>Listrik</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="harga_sewa" class="form-label">Harga Sewa</label>
            <input type="number" name="hargasewa" class="form-control" value="{{ old('hargasewa', $mobil->hargasewa) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="Tersedia" {{ $mobil->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="Disewa" {{ $mobil->status == 'Disewa' ? 'selected' : '' }}>Disewa</option>
                <option value="Maintenance" {{ $mobil->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar</label>
            @if ($mobil->gambar)
                <img src="{{ asset('storage/' . $mobil->gambar) }}" width="150"><br><br>
            @endif
            <input type="file" class="form-control" name="gambar" accept="image/*">
        </div>

        <a href="{{ route('mobil-show') }}" class="btn btn-danger">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection