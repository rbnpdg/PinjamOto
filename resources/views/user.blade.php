@extends('layout/admin-nav')

@section('content')
<div class="card-header pb-0">
    <h6>Tabel user</h6>
</div>
<div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">
            <h2>Data User</h2>
            <a href="{{ route('user-add') }}" class="btn btn-primary py-2">Tambah user</a>
        </div>
        
        <table class="table table-bordered"> 
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No telp</th>
                    <th>Alamat</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user -> nama}}</td>
                    <td>{{ $user -> username}}</td>
                    <td>{{ $user -> email}}</td>
                    <td>{{ $user -> telepon}}</td>
                    <td>{{ $user -> alamat}}</td>
                    <td>{{ $user -> role}}</td>
                    <td>
                        <a href="{{ route('user-edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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