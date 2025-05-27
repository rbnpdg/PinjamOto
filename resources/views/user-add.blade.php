@extends('layout/admin-nav')

@section('content')
<h2 class="mt-5 mb-4 text-center">Tambah User</h2>
<div class="d-flex justify-content-center ml-4 mr-4">
    <form action="{{ route('user-store') }}" class="mb-4" method="POST" style="width: 50%;">
        @csrf
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" required>
        </div>

        <div class="mb-3">
            <label for="telepon" class="form-label">No Telp</label>
            <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon') }}" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="Konsumen" {{ old('role') == 'Konsumen' ? 'selected' : '' }}>Konsumen</option>
                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="Owner" {{ old('role') == 'Owner' ? 'selected' : '' }}>Owner</option>
            </select>
        </div>

        <a href="{{ route('user-show') }}" class="btn btn-danger">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
    @if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            confirmButtonText: 'Tutup'
        });
    </script>
    @endif

</div>
@endsection

@section('scripts')
<script>
    // Show the error modal if there are any validation errors
    @if ($errors->any())
        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'), {
            keyboard: false
        });
        errorModal.show();
    @endif
</script>
@endsection