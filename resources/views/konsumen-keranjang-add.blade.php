@extends('layout/user-nav')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Mobil : {{ $mobil->nama }} ({{ $mobil->tahun }})</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('keranjang-add', $mobil->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="tanggal_mulai" class="form-label">Tanggal Mulai Sewa</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal Akhir Sewa</label>
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('mobil-katalog') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
