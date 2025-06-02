@extends('layout/admin-nav')

@section('content')
<div class="container mt-4">
    <h2>Tambah Transaksi Baru</h2>
    
    <form action="{{ route('transaksi-store') }}" method="POST">
        @csrf

        <div class="mb-3">  
            <label for="user_id" class="form-label">Pilih Konsumen</label>
            <select name="user_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Konsumen --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->nama }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="mobil_id" class="form-label">Pilih Mobil</label>
            <select name="mobil_id" class="form-select" required>
                <option value="" disabled selected>-- Pilih Mobil --</option>
                @foreach($mobils as $mobil)
                    <option value="{{ $mobil->id }}">{{ $mobil->nama }} - {{ $mobil->tnkb }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="Menunggu">Menunggu</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tambah Transaksi</button>
    </form>
</div>
@endsection
