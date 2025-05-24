@extends('layout/admin-nav')

@section('content')
<h2 class="mt-5 mb-4 text-center">Tambah Mobil</h2>
<div class="d-flex justify-content-center ml-4 mr-4">
    <form action="{{ route('mobil-store') }}" class="mb-4" method="POST" style="width: 50%;">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Mobil</label>
            <input type="text" name="nama" id="nama" class="form-control" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required>
        </div>

        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="number" name="tahun" id="tahun" min="2000" max="2099" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tnkb" class="form-label">TNKB</label>
            <input name="tnkb" id="tnkb" class="form-control" rows="3" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="Tersedia">Tersedia</option>
                <option value="Disewa">Disewa</option>
                <option value="Maintenance">Maintenance</option>
            </select>
        </div>

        <a href="{{ route('mobil-show') }}" class="btn btn-danger">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection