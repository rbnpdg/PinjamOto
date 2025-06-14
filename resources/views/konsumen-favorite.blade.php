@extends('layout/user-nav')

@section('title', 'Favorit')

@section('content')

<section class="py-5">
    <div class="container">

        <h2 class="fw-bold text-dark mb-6 text-center">Mobil Favorit Anda</h2>

        <!-- Notifikasi (Success/Error) -->
        @if (session('success'))
            <div class="alert alert-success position-relative text-center py-3 rounded-lg mb-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" aria-label="Close" onclick="this.parentElement.style.display='none'"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger position-relative text-center py-3 rounded-lg mb-4" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2" aria-label="Close" onclick="this.parentElement.style.display='none'"></button>
            </div>
        @endif

        @if ($favoriteMobils->isEmpty())
            <div class="alert alert-info text-center py-5 rounded-lg shadow-sm">
                <p class="h5 mb-3">Anda belum memiliki mobil favorit.</p>
                <p class="mb-4">Cari mobil yang Anda suka dan tambahkan ke favorit!</p>
                <a href="{{ url('/katalog') }}" class="btn btn-primary fw-bold px-4 py-2 rounded-pill">
                    Cari Mobil Sekarang
                </a>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($favoriteMobils as $mobil)
                    <div class="col">
                        <div class="card h-100 shadow-sm hover-elevate rounded-xl"> {{-- Menggabungkan rounded-xl --}}
                            @if ($mobil->gambar)
                                <img src="{{ asset('storage/' . $mobil->gambar) }}" class="card-img-top mobil-image" alt="Gambar Mobil" style="height: 250px; object-fit: cover;">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 250px; border-top-left-radius: calc(1rem - 1px); border-top-right-radius: calc(1rem - 1px);"> {{-- Menyesuaikan border-radius dengan rounded-xl --}}
                                    <small>Tidak ada gambar</small>
                                </div>
                            @endif
                            <div class="card-body d-flex flex-column p-4">
                                <div>
                                    <h5 class="card-title fw-semibold text-dark mb-2">{{ $mobil->nama ?? 'Nama Mobil Tidak Diketahui' }} ({{ $mobil->tahun ?? 'N/A' }})</h5>
                                    {{-- Menambahkan detail mobil seperti di katalog --}}
                                    <p class="card-text mb-1"><strong>Tipe:</strong> {{ $mobil->tipe ?? 'N/A' }}</p>
                                    <p class="card-text mb-1"><strong>Transmisi:</strong> {{ $mobil->transmisi ?? 'N/A' }}</p>
                                    <p class="card-text mb-1"><strong>BBM:</strong> {{ $mobil->bbm ?? 'N/A' }}</p>
                                    <p class="card-text mb-1"><strong>Kapasitas:</strong> {{ $mobil->kapasitas ?? 'N/A' }} orang</p>
                                    {{-- Menggunakan $mobil->hargasewa untuk harga --}}
                                    <p class="card-text fw-bold text-danger">Rp {{ number_format($mobil->hargasewa ?? 0, 0, ',', '.') }} / hari</p>
                                </div>

                                <div class="card-footer bg-transparent border-0 d-flex justify-content-between px-0 pb-0 mt-auto">
                                    @auth
                                        {{-- $pesananAktif perlu diteruskan dari FavoriteController ke view ini agar berfungsi --}}
                                        @if (isset($pesananAktif) && $pesananAktif)
                                            <button class="btn btn-outline-secondary w-100 rounded-end-0" disabled>Selesaikan Transaksi Anda</button>
                                        @else
                                            <a href="{{ route('mobil-pesan', $mobil->id) }}" class="btn btn-outline-primary w-100 rounded-end-0">Sewa Sekarang</a>
                                        @endif
                                    @else
                                        <a href="{{ route('login-show') }}" class="btn btn-outline-primary w-100 rounded-end-0">Login untuk Sewa</a>
                                    @endauth

                                    <form action="{{ route('toggle-favorit', $mobil->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary rounded-start-0" {{ Auth::check() && (isset($pesananAktif) && $pesananAktif) ? 'disabled' : '' }}>
                                            @auth
                                                @if (Auth::user()->favorites->contains($mobil->id))
                                                    <i class="bi bi-heart-fill text-danger"></i>
                                                @else
                                                    <i class="bi bi-heart"></i>
                                                @endif
                                            @else
                                                <i class="bi bi-heart"></i>
                                            @endauth
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Paginasi -->
            <div class="d-flex justify-content-center mt-5">
                {{ $favoriteMobils->links('pagination::bootstrap-5') }} {{-- Menggunakan paginasi Bootstrap --}}
            </div>
        @endif
    </div> {{-- Penutup div.container --}}
</section> {{-- Penutup section --}}

<script>
    // SweetAlert2 for notifications
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-lg shadow-lg'
            }
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2500,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-lg shadow-lg'
            }
        });
    @endif
</script>

{{-- Custom styles untuk override atau menambahkan gaya. Sebaiknya dipindahkan ke file CSS global Anda. --}}
<style>
    /* Menggunakan Bootstrap grid system untuk konsistensi */
    .row.g-4 {
        --bs-gutter-x: 1.5rem; /* Default gutter Bootstrap */
        --bs-gutter-y: 1.5rem;
    }
    .card.rounded-xl {
        border-radius: 1rem !important; /* Contoh: Menyesuaikan dengan rounded-xl Tailwind */
    }
    .hover-elevate:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }
    .mobil-image {
        width: 100%;
        height: 200px; /* Sesuaikan tinggi gambar agar konsisten */
        object-fit: cover;
    }
    .card-body.d-flex.flex-column {
        padding: 1.5rem; /* Menyesuaikan padding p-6 Tailwind ke Bootstrap */
    }
    .card-footer.mt-auto {
        margin-top: auto !important; /* Memastikan footer selalu di bawah */
    }
    /* Styles untuk notifikasi disesuaikan ke Bootstrap */
    .alert {
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem;
    }
    .alert-success {
        color: #0f5132;
        background-color: #d1e7dd;
        border-color: #badbcc;
    }
    .alert-danger {
        color: #842029;
        background-color: #f8d7da;
        border-color: #f5c2c7;
    }
    .alert-info {
        color: #055160;
        background-color: #cff4fc;
        border-color: #b6effb;
    }
    .btn-close {
        /* CSS untuk tombol close Bootstrap */
        background-color: transparent;
        border: 0;
        opacity: 0.5;
        font-size: 1.25rem;
        padding: 0.25rem 0.25rem;
        cursor: pointer;
    }
    .btn-close:hover {
        opacity: 0.75;
    }
    /* Pastikan icon Bootstrap terload. Ini idealnya di user-nav.blade.php */
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
    /* Pastikan font Inter terload. Ini idealnya di user-nav.blade.php */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
</style>

@endsection
