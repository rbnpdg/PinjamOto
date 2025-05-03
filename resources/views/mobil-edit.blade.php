@extends('layout/admin-nav')

<h2 class="mb-4 text-center">Edit Mobil</h2>
<div class="d-flex justify-content-center">
    <form action="{{ route('mobil-update', $mobil->id) }}" method="POST" style="width: 50%;">
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
            <label for="tnkb" class="form-label">TNKB</label>
            <input type="text" name="tnkb" id="tnkb" class="form-control" value="{{ old('tnkb', $mobil->tnkb) }}" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase();" required>
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

        <a href="{{ route('mobil-show') }}" class="btn btn-danger">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
