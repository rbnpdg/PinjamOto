@extends('layout.user-nav')

@section('title', 'Kontak Kami') {{-- Menambahkan atau memastikan title --}}

@section('content')
<section class="py-8 py-md-12 bg-white d-flex align-items-center"> {{-- Menyesuaikan background dan alignment --}}
    <div class="container">
        <div class="row align-items-center justify-content-center g-5"> {{-- g-5 untuk gap yang lebih besar --}}
            {{-- Kolom Kiri: Gambar (sesuai gambar referensi) --}}
            <div class="col-12 col-md-6 order-md-1 order-2 text-center text-md-start"> {{-- Order agar gambar di bawah info di mobile --}}
                <img src="{{ asset('img/camryrmv.png') }}" {{-- Menggunakan gambar dari contoh 'Tentang Kami' --}}
                     alt="Ilustrasi Kontak"
                     class="img-fluid" {{-- img-fluid untuk responsif --}}
                     style="max-width: 400px; height: auto; object-fit: cover;"> {{-- Style langsung untuk ukuran --}}
            </div>

            {{-- Kolom Kanan: Teks dan Informasi Kontak (TANPA FORM) --}}
            <div class="col-12 col-md-6 order-md-2 order-1 text-center text-md-start"> {{-- Order agar info di atas gambar di mobile --}}
                <h2 class="fw-bold mb-4 text-dark"><span class="text-danger">Hubungi</span> Kami</h2> {{-- Gaya judul seperti 'Tentang Kami' --}}
                <p class="lead text-muted mb-5" style="font-size: 1rem; line-height: 1.6;"> {{-- Menyesuaikan font size --}}
                    Kami siap membantu Anda! Untuk pertanyaan, saran, atau dukungan, silakan hubungi kami melalui informasi di bawah ini. Kami akan berusaha merespons secepatnya.
                </p>

                <div class="contact-info text-dark mb-4">
                    <h4 class="fw-semibold mb-3">Informasi Kontak</h4>
                    <p class="fs-5 mb-2">
                        <i class="bi bi-envelope-fill me-2 text-danger"></i> Email: <a href="mailto:aaa@example.com" class="text-decoration-none text-dark hover-effect">aaa@example.com</a>
                    </p>
                    <p class="fs-5 mb-2">
                        <i class="bi bi-phone-fill me-2 text-danger"></i> Telepon: <a href="tel:0892382382832" class="text-decoration-none text-dark hover-effect">0892382382832</a>
                    </p>
                    <p class="fs-5 mt-4">
                        <i class="bi bi-geo-alt-fill me-2 text-danger"></i> Alamat: Jl. Contoh Raya No. 123, Kota Anda
                    </p>
                </div>

                {{-- Anda bisa menambahkan tombol lain jika diperlukan, misalnya link ke WhatsApp --}}
                <div class="mt-5">
                    <a href="https://wa.me/0892382382832" class="btn btn-success btn-lg rounded-pill fw-bold text-white shadow-sm hover-grow d-inline-flex align-items-center">
                        <i class="bi bi-whatsapp me-2"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Custom styles untuk elemen spesifik di halaman ini.
     Sebaiknya dipindahkan ke file CSS global Anda untuk praktik terbaik. --}}
<style>
    .rounded-lg { border-radius: 0.5rem !important; } /* Mengatur ulang border-radius Bootstrap */
    .shadow-lg { box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important; }
    .shadow-sm { box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important; }

    /* Gaya untuk efek hover tombol */
    .hover-grow:hover {
        transform: scale(1.02);
        transition: transform 0.2s ease-in-out;
    }

    /* Efek hover untuk link kontak */
    .text-dark.hover-effect:hover {
        color: #dc3545 !important; /* Warna merah Bootstrap */
        transition: color 0.2s ease-in-out;
    }
</style>

{{-- SweetAlert2 script. Idealnya ini dimuat di layout/user-nav.blade.php.
     Karena tidak ada form, script submit form dihapus. Notifikasi session tetap relevan. --}}
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

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            timer: 2500,
            showConfirmButton: false
        });
    @endif
</script>
@endsection
