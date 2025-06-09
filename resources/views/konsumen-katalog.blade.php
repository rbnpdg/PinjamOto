@extends('layout/user-nav')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h3 class="fw-bold mb-0">Pilihan Mobil</h3>
                <form method="GET" action="{{ route('katalog-filter') }}" class="d-flex flex-wrap gap-2 align-items-end">
                    <div>
                        <select name="tipe" class="form-select form-select-sm">
                            <option value="">Tipe</option>
                            <option value="mpv" {{ request('tipe') == 'mpv' ? 'selected' : '' }}>MPV</option>
                            <option value="suv" {{ request('tipe') == 'suv' ? 'selected' : '' }}>SUV</option>
                            <option value="sedan" {{ request('tipe') == 'sedan' ? 'selected' : '' }}>Sedan</option>
                            <option value="citycar" {{ request('tipe') == 'citycar' ? 'selected' : '' }}>City Car</option>
                        </select>
                    </div>
                    <div>
                        <select name="bbm" class="form-select form-select-sm">
                            <option value="">Bahan Bakar</option>
                            <option value="bensin" {{ request('bbm') == 'bensin' ? 'selected' : '' }}>Bensin</option>
                            <option value="diesel" {{ request('bbm') == 'diesel' ? 'selected' : '' }}>Diesel</option>
                            <option value="listrik" {{ request('bbm') == 'listrik' ? 'selected' : '' }}>Listrik</option>
                        </select>
                    </div>
                    <div>
                        <select name="tahun" class="form-select form-select-sm">
                            <option value="">Tahun Produksi</option>
                            <option value="2010-2015" {{ request('tahun') == '2010-2015' ? 'selected' : '' }}>2010-2015</option>
                            <option value="2016-2020" {{ request('tahun') == '2016-2020' ? 'selected' : '' }}>2016-2020</option>
                            <option value="2021-2025" {{ request('tahun') == '2021-2025' ? 'selected' : '' }}>2021-2025</option>
                        </select>
                    </div>
                    <div>
                        <select name="harga" class="form-select form-select-sm">
                            <option value="">Harga</option>
                            <option value="0-300000" {{ request('harga') == '0-300000' ? 'selected' : '' }}>≤ Rp300.000</option>
                            <option value="300001-500000" {{ request('harga') == '300001-500000' ? 'selected' : '' }}>300K–500K</option>
                            <option value="500001-1000000" {{ request('harga') == '500001-1000000' ? 'selected' : '' }}>500K–1jt</option>
                            <option value="1000001-99999999" {{ request('harga') == '1000001-99999999' ? 'selected' : '' }}>≥ 1jt</option>
                        </select>
                    </div>
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-primary">Terapkan Filter</button>
                        <a href="{{ route('mobil-katalog') }}" class="btn btn-sm btn-outline-danger">Reset</a>
                    </div>
                </form>
            </div>


            @forelse ($mobil as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="mobil-image" width="100%" alt="Gambar Mobil">
                        @else
                            <small>Tidak ada gambar</small>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama }} ({{ $item->tahun }})</h5>
                            <p class="card-text mb-1"><strong>Tipe:</strong> {{ $item->tipe }}</p>
                            <p class="card-text mb-1"><strong>Transmisi:</strong> {{ $item->transmisi }}</p>
                            <p class="card-text mb-1"><strong>BBM:</strong> {{ $item->bbm }}</p>
                            <p class="card-text mb-1"><strong>Kapasitas:</strong> {{ $item->kapasitas }} orang</p>
                            <p class="card-text fw-bold text-danger">Rp {{ number_format($item->hargasewa, 0, ',', '.') }} / hari</p>
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-between">
                                @auth
                                    <a href="{{ route('mobil-pesan', $item->id) }}" class="btn btn-outline-primary w-100 rounded-end-0">Sewa Sekarang</a>
                                @else
                                    <a href="{{ route('login-show') }}" class="btn btn-outline-primary w-100 rounded-end-0">Login untuk Sewa</a>
                                @endauth
                                <form action="{{ route('tambah-keranjang', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary rounded-start-0">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Belum ada mobil yang tersedia.</div>
                </div>
            @endforelse
        </div>
    </div>
</section>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection

