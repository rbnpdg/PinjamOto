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
  async function generatePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const content = document.querySelector('.table-responsive'); // Ganti sesuai bagian yang mau dicetak

    await html2canvas(content).then((canvas) => {
      const imgData = canvas.toDataURL('image/png');
      const imgProps= doc.getImageProperties(imgData);
      const pdfWidth = doc.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      const marginX = 20;
      const marginY = 20;
      const contentWidth = pdfWidth - marginX * 2;

      const scaledHeight = (imgProps.height * contentWidth) / imgProps.width;

      doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
      doc.save('transaksi.pdf');
    });
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
