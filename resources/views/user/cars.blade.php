@extends('layout.user-nav')

@section('content')
<section class="py-16">
    <div class="container mx-auto px-4">
        <h3 class="text-2xl font-bold mb-6">Pilihan Mobil</h3>
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Contoh mobil -->
            <div class="bg-white p-4 rounded shadow">
                <img src="https://source.unsplash.com/400x200/?car" alt="Mobil" class="rounded mb-4">
                <h4 class="text-xl font-bold">Toyota Avanza</h4>
                <p class="text-gray-600">Rp 400.000 / hari</p>
                <a href="#" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Sewa</a>
            </div>
        </div>
    </div>
</section>
@endsection