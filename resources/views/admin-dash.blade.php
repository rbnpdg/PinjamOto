@extends('layout/admin-nav')

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
                <!-- Contoh data statis -->
                <tr>
                    <td>1</td>
                    <td>Toyota Avanza G</td>
                    <td>2022</td>
                    <td>BE 1234 XY</td>
                    <td>Tersedia</td>
                    <td>
                        <button class="btn btn-warning btn-sm" action="{{ route('mobil-edit') }}">Edit</button>
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </td>
                </tr>
                <!-- Data lainnya akan di-generate dari backend -->
            </tbody>
        </table>
    </div>