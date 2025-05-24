@extends('layout/admin-nav')

@section('content')
<div class="card-header pb-0">
    <h6>Tabel Mobil</h6>
</div>
<div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>Data Mobil Rental</h2>
            <a href="{{ route('mobil-add') }}" class="btn btn-primary py-2">Tambah Mobil</a>
        </div>
        
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Mobil</th>
                    <th>Tahun</th>
                    <th>Plat Nomor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mobil as $mobil)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mobil -> nama}}</td>
                    <td>{{ $mobil -> tahun}}</td>
                    <td>{{ $mobil -> tnkb}}</td>
                    <td>{{ $mobil -> status}}</td>
                    <td>
                        <a href="{{ route('mobil-edit', $mobil->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form id="delete-form-{{ $mobil->id }}" action="{{ route('mobil-del', $mobil->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete({{ $mobil->id }})">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach 
                <!-- Data lainnya akan di-generate dari backend -->
            </tbody>
        </table>
    </div>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data mobil akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection