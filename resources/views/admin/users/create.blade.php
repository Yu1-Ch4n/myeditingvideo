@extends('layouts.admin.master')

@section('usersActive')
    text-primary
@endsection

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Pengguna</li>
        </ol>
    </nav>
    <hr><br>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Data Pengguna
                </div>
                <div class="card-body">
                    {{-- Tambahkan enctype="multipart/form-data" untuk upload file --}}
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="name" class="form-label">Nama Pengguna</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Gender --}}
                            <div class="col-lg-6 mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                    <option value="Lainnya" {{ old('gender') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Email --}}
                            <div class="col-lg-6 mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Phone --}}
                            <div class="col-lg-6 mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Instagram --}}
                            <div class="col-lg-6 mb-3">
                                <label for="instagram" class="form-label">Akun Instagram (Opsional)</label>
                                <input type="text" class="form-control @error('instagram') is-invalid @enderror"
                                    id="instagram" name="instagram" value="{{ old('instagram') }}">
                                @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Field Role --}}
                            <div class="col-lg-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role"
                                    name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="author" {{ old('role') == 'author' ? 'selected' : '' }}>Author</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    {{-- Tambahkan opsi 'user' --}}
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Password --}}
                            <div class="col-lg-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            {{-- Field Image --}}
                            <div class="col-lg-6 mb-3">
                                <label for="image" class="form-label">Gambar Profil (Opsional)</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file"
                                    id="image" name="image">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Alamat --}}
                            <div class="col-12">
                                <h5 class="mt-3 mb-3 border-bottom pb-2">Detail Alamat</h5>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label for="address" class="form-label">Alamat Lengkap</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                <select class="form-select @error('province') is-invalid @enderror" id="province"
                                    name="province">
                                    <option value="">Pilih Provinsi</option>
                                    {{-- Opsi provinsi akan dimuat via JavaScript --}}
                                </select>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="city" class="form-label">Kota/Kabupaten</label>
                                <select class="form-select @error('city') is-invalid @enderror" id="city"
                                    name="city" disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    {{-- Opsi kota akan dimuat via JavaScript setelah provinsi dipilih --}}
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="postal_code" class="form-label">Kode Pos</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                    id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Buat Pengguna</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat provinsi
            function loadProvinces() {
                // Ini adalah placeholder. Anda harus menggantinya dengan API yang sebenarnya
                // Contoh API dummy: https://dev.farizdotid.com/api/daerahindonesia/provinsi
                // Pastikan Anda mendapatkan API Key jika API memerlukannya
                $.ajax({
                    url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', // Contoh API publik
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#province').empty().append('<option value="">Pilih Provinsi</option>');
                        $.each(data, function(key, value) {
                            $('#province').append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });
                        // Set old value if any
                        if ("{{ old('province') }}") {
                            $('#province').val("{{ old('province') }}").trigger('change');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching provinces:", status, error);
                        $('#province').empty().append(
                            '<option value="">Gagal memuat provinsi</option>');
                    }
                });
            }

            // Fungsi untuk memuat kota/kabupaten berdasarkan ID provinsi
            function loadCities(provinceId) {
                if (provinceId) {
                    $.ajax({
                        url: 'https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' + provinceId +
                            '.json', // Contoh API publik
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#city').empty().append('<option value="">Pilih Kota/Kabupaten</option>')
                                .prop('disabled', false);
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });
                            // Set old value if any
                            if ("{{ old('city') }}") {
                                $('#city').val("{{ old('city') }}");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching cities:", status, error);
                            $('#city').empty().append('<option value="">Gagal memuat kota</option>')
                                .prop('disabled', true);
                        }
                    });
                } else {
                    $('#city').empty().append('<option value="">Pilih Kota/Kabupaten</option>').prop('disabled',
                        true);
                }
            }

            // Panggil fungsi loadProvinces saat dokumen siap
            loadProvinces();

            // Event listener saat provinsi dipilih
            $('#province').on('change', function() {
                var provinceId = $(this).val();
                loadCities(provinceId);
            });

            // Jika ada old('province') saat page load, pastikan city juga terisi
            if ("{{ old('province') }}") {
                loadCities("{{ old('province') }}");
            }
        });
    </script>
@endpush
