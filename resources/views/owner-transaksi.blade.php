    @extends('layout/owner-nav')

    @section('content')
        <div class="container mt-5">
            <div class="d-flex justify-content-between mb-3">
                <h2>Data Transaksi</h2>
                <button class="btn btn-primary py-2" onclick="generatePDF()">Generate Laporan</button>
        </div>

        <form method="GET" action="{{ route('transaksi-owner') }}" class="row g-2 mb-4 justify-content-end">
            <div class="col-md-2">
                <select name="rentang_waktu" class="form-select">
                    <option value="">Rentang Waktu</option>
                    <option value="7" {{ request('rentang_waktu') == '7' ? 'selected' : '' }}>1 Minggu</option>
                    <option value="14" {{ request('rentang_waktu') == '14' ? 'selected' : '' }}>2 Minggu</option>
                    <option value="30" {{ request('rentang_waktu') == '30' ? 'selected' : '' }}>1 Bulan</option>
                    <option value="90" {{ request('rentang_waktu') == '90' ? 'selected' : '' }}>3 Bulan</option>
                    <option value="180" {{ request('rentang_waktu') == '180' ? 'selected' : '' }}>6 Bulan</option>
                    <option value="365" {{ request('rentang_waktu') == '365' ? 'selected' : '' }}>1 Tahun</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Status</option>
                    <option value="Berjalan" {{ request('status') == 'Berjalan' ? 'selected' : '' }}>Berjalan</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="metode" class="form-select">
                    <option value="">Metode Pembayaran</option>
                    <option value="bni" {{ request('metode') == 'gopay' ? 'selected' : '' }}>Gopay</option>
                    <option value="bca" {{ request('metode') == 'bca' ? 'selected' : '' }}>Transfer BCA</option>
                    <option value="bni" {{ request('metode') == 'bni' ? 'selected' : '' }}>Transfer BNI</option>
                    <option value="cod" {{ request('metode') == 'cod' ? 'selected' : '' }}>Cash</option>
                </select>
            </div>

            <div class="col-md-2">
                <select name="harga" class="form-select">
                    <option value="">Rentang Harga</option>
                    <option value="<1juta" {{ request('harga') == '<1juta' ? 'selected' : '' }}>< 1 Juta</option>
                    <option value="1-2juta" {{ request('harga') == '1-2juta' ? 'selected' : '' }}>1 - 2 Juta</option>
                    <option value="2-3juta" {{ request('harga') == '2-3juta' ? 'selected' : '' }}>2 - 3 Juta</option>
                    <option value=">3juta" {{ request('harga') == '>3juta' ? 'selected' : '' }}>> 3 Juta</option>
                </select>
            </div>

            <div class="col-md-2">
                <input type="text" name="search" class="form-control" placeholder="Cari Nama / Mobil" value="{{ request('search') }}">
            </div>

            <div class="col-md-1 d-grid">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
            <div class="col-md-1 d-grid">
                <a class="btn btn-outline-danger" href="{{ route('transaksi-owner') }}">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Konsumen</th>
                        <th>Mobil</th>
                        <th>Tanggal Transaksi</th>
                        <th>Durasi (hari)</th>
                        <th>Biaya</th>
                        <th>Metode</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $transaksi->user->nama }}</td>
                            <td>{{ $transaksi->mobil->nama ?? '-' }} - {{ $transaksi->mobil->tnkb ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->diffInDays($transaksi->tanggal_selesai) }} hari</td>
                            <td>Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($transaksi->metode_pembayaran) ?? '-' }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $transaksi->status == 'Berjalan' ? 'warning' : 
                                    ($transaksi->status == 'Dibatalkan' ? 'danger' : 
                                    ($transaksi->status == 'Selesai' ? 'success' : 'secondary')) }}">
                                    {{ $transaksi->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script>
    function generatePDF() {
        var docDefinition = {
            pageOrientation: 'landscape',
            pageMargins: [40, 60, 40, 60],
            header: {
                text: 'Laporan Transaksi PinjamOTO',
                alignment: 'center',
                fontSize: 10,
                bold: true,
                margin: [10, 20, 10, 20]
            },
            content: [
                {
                    table: {
                        headerRows: 1,
                        widths: ['auto', '*', '*', '*', '*', '*', '*', '*'],
                        body: [
                            ['No', 'Konsumen', 'Mobil', 'Tgl Transaksi', 'Durasi (hari)', 'Biaya', 'Pembayaran', 'Status'],
                            @foreach($transaksis as $i => $t)
                            [
                                '{{ $i+1 }}',
                                '{{ $t->user->nama ?? "-" }}',
                                '{{ $t->mobil->nama ?? "-" }} - {{ $t->mobil->tnkb ?? "-" }}',
                                '{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d-m-Y') }}',
                                '{{ \Carbon\Carbon::parse($t->tanggal_mulai)->diffInDays($t->tanggal_selesai) }}',
                                'Rp {{ number_format($t->total_biaya, 0, ",", ".") }}',
                                '{{ ucfirst($t->metode_pembayaran) ?? "-" }}',
                                '{{ $t->status }}'
                            ],
                            @endforeach
                        ]
                    },
                    layout: 'lightHorizontalLines'
                }
            ]
        };

        pdfMake.createPdf(docDefinition).download('laporan-transaksi.pdf');
    }
    </script>

    @endsection

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif
