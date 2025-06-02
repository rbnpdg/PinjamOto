    @extends('layout/owner-nav')

    @section('content')
        <div class="card-header pb-0">
            <h6>Tabel Transaksi</h6>
        </div>

        <div class="container mt-5">
            <div class="d-flex justify-content-between mb-3">
                <h2>Data Transaksi</h2>
                <button class="btn btn-primary py-2" onclick="generatePDF()">Generate Laporan</button>
        </div>

        <form action="{{ route('transaksi-owner') }}" method="GET" class="mb-4 d-flex gap-2 align-items-end">
            <div>
                <label for="tanggal_mulai">Dari Tanggal</label>
                <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
            </div>
            <div>
                <label for="tanggal_selesai">Sampai Tanggal</label>
                <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
            </div>
            <div>
                <button type="submit" class="btn btn-secondary">Filter</button>
                <a href="{{ route('transaksi-owner') }}" class="btn btn-outline-danger">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Konsumen</th>
                        <th>Mobil</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaksi->user->nama }}</td>
                            <td>{{ $transaksi->mobil->nama ?? '-' }} - {{ $transaksi->mobil->tnkb ?? '-' }}</td>
                            <td>{{ $transaksi->tanggal_mulai }}</td>
                            <td>{{ $transaksi->tanggal_selesai }}</td>
                            <td>Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}</td>
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
                            <td colspan="7" class="text-center">Belum ada data transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <script>
    function generatePDF() {
    var docDefinition = {
        pageMargins: [40, 60, 40, 60], // [left, top, right, bottom]
        header: {
        text: 'Laporan Transaksi PinjamOTO',
        alignment: 'center',
        fontSize: 16,
        bold: true,
        margin: [0, 20, 0, 20]
        },
        content: [
        {
            table: {
            headerRows: 1,
            widths: ['auto', '*', '*', '*', '*', '*', '*'],
            body: [
                ['No', 'Konsumen', 'Mobil', 'Tgl Mulai', 'Tgl Selesai', 'Biaya', 'Status'],
                @foreach($transaksis as $i => $t)
                [
                    '{{ $i+1 }}',
                    '{{ $t->user->nama ?? "-" }}',
                    '{{ $t->mobil->nama ?? "-" }} - {{ $t->mobil->tnkb ?? "-" }}',
                    '{{ $t->tanggal_mulai }}',
                    '{{ $t->tanggal_selesai }}',
                    'Rp {{ number_format($t->total_biaya, 0, ",", ".") }}',
                    '{{ $t->status }}'
                ],
                @endforeach
            ]
            }
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
