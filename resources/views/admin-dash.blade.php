@extends('layout/admin-nav')

@section('content')
  <table class="table align-items-center mb-0">
    <thead>
      <tr>
        <th>Nama Mobil</th>
        <th>Tahun</th>
        <th>Plat Nomor</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Toyota Avanza G</td>
        <td>2022</td>
        <td>BE 1234 XY</td>
        <td>Tersedia</td>
        <td>
          <button class="btn btn-warning btn-sm">Edit</button>
          <button class="btn btn-danger btn-sm">Hapus</button>
        </td>
      </tr>
    </tbody>
  </table>
@endsection
