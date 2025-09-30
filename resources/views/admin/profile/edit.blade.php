@extends('layouts.admin.master')

@section('usersActive')
    text-primary
@endsection

@section('content')
    {{-- Tambahkan enctype="multipart/form-data" untuk upload file --}}
    <form method="post" action="{{ route('admin.profile.update') }}" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="row justify-content-center">
            <div class="col-lg-8 mb-3">
                <div class="card mb-4 h-100">
                    <div class="card-body">
                        <header>
                            <h2 class="h5 mb-2">
                                Profil Pengguna
                            </h2>
                            <hr>
                            <p class="mt-1 text-muted">
                                "Perbarui informasi profil dan alamat email akun Anda."
                            </p>
                        </header>
                        <div class="row">
                            <div class="col-lg-12 mb-2">
                                <label for="name" class="form-label">Nama Pengguna</label>
                                <input id="name" name="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Gender --}}
                            <div class="col-lg-6 mb-2">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki"
                                        {{ old('gender', $user->gender) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ old('gender', $user->gender) == 'Perempuan' ? 'selected' : '' }}>Perempuan
                                    </option>
                                    <option value="Lainnya"
                                        {{ old('gender', $user->gender) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-6 mb-2">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input id="email" name="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Phone --}}
                            <div class="col-lg-6 mb-2">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input id="phone" name="phone" type="text"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone', $user->phone) }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Field Instagram --}}
                            <div class="col-lg-6 mb-2">
                                <label for="instagram" class="form-label">Akun Instagram (Opsional)</label>
                                <input id="instagram" name="instagram" type="text"
                                    class="form-control @error('instagram') is-invalid @enderror"
                                    value="{{ old('instagram', $user->instagram) }}">
                                @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bagian untuk mengubah password --}}
                            <small class="text-muted my-3">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</small>
                            <div class="col-lg-4 mb-2">
                                <label for="current_password" class="form-label">Password Sekarang</label>
                                <input id="current_password" name="current_password" type="password"
                                    class="form-control @error('current_password') is-invalid @enderror"
                                    autocomplete="current-password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 mb-2">
                                <label for="password" class="form-label">Password Baru</label>
                                <input id="password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-lg-4 mb-2">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    class="form-control" autocomplete="new-password">
                            </div>

                            {{-- Bagian Alamat --}}

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
                        <div class="d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary me-1">Simpan Perubahan</button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-3">
                {{-- Field Image --}}
                <div class="card card-body h-100">
                    <div class="mb-3">
                        <header>
                            <h2 class="h5 mb-2">
                                Gambar Profil
                            </h2>
                            <hr>
                        </header>
                        @if ($user->image)
                            <div class="col-lg-12 mb-2">
                                <img src="{{ asset('storage/' . $user->image) }}" alt="Current Profile Image"
                                    class="img-thumbnail" style="max-width: 150px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="remove_image"
                                        id="remove_image" value="1">
                                    <label class="form-check-label" for="remove_image">
                                        Hapus Gambar Saat Ini
                                    </label>
                                </div>
                            </div>
                        @endif
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                            name="image">
                        <small class="text-muted">Upload gambar baru untuk mengganti yang lama, atau centang "Hapus
                            Gambar Saat Ini".</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

    </form>
    <hr>

    <div class="mb-0">
        <header>
            <h2 class="h5 mb-3">
                Hapus Akun Pengguna
            </h2>
            <p class="mt-1 text-muted" style="font-size: small">
                Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara
                permanen.
                Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda
                simpan.
            </p>
        </header>

        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal"
            data-bs-target="#confirmUserDeletionModal">
            Hapus Akun
        </button>

        <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1"
            aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" action="{{ route('admin.profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                                Apakah Anda yakin ingin menghapus akun Anda?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <p class="text-sm text-muted">
                                Setelah akun Anda dihapus, semua sumber daya dan datanya akan
                                dihapus
                                secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi bahwa
                                Anda
                                ingin menghapus akun Anda secara permanen.
                            </p>

                            <div class="mb-3">
                                <label for="password_delete" class="visually-hidden">Password</label>
                                {{-- Label tersembunyi untuk aksesibilitas --}}
                                <input id="password_delete" name="password" type="password"
                                    class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                    placeholder="Password">
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-danger">Hapus Akun</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Simpan nilai provinsi dan kota pengguna yang sudah ada
            const userProvinceId =
                "{{ old('province', $user->province) }}"; // Asumsi Anda menyimpan ID provinsi di DB
            const userCityId = "{{ old('city', $user->city) }}"; // Asumsi Anda menyimpan ID kota di DB

            // Fungsi untuk memuat provinsi
            function loadProvinces() {
                $.ajax({
                    url: 'https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#province').empty().append('<option value="">Pilih Provinsi</option>');
                        $.each(data, function(key, value) {
                            $('#province').append('<option value="' + value.id + '">' + value
                                .name + '</option>');
                        });

                        // Set nilai provinsi jika ada (dari old() atau dari user data)
                        if (userProvinceId) {
                            $('#province').val(userProvinceId);
                            // Trigger change untuk memuat kota jika provinsi sudah terpilih
                            if (userCityId) {
                                loadCities(userProvinceId, userCityId);
                            } else {
                                loadCities(
                                    userProvinceId
                                ); // Load cities without pre-selecting if no userCityId
                            }
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
            function loadCities(provinceId, selectedCityId = null) {
                if (provinceId) {
                    $('#city').prop('disabled', true); // Disable while loading
                    $.ajax({
                        url: 'https://www.emsifa.com/api-wilayah-indonesia/api/regencies/' + provinceId +
                            '.json',
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#city').empty().append('<option value="">Pilih Kota/Kabupaten</option>')
                                .prop('disabled', false);
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' + value
                                    .name + '</option>');
                            });
                            // Set nilai kota jika ada (dari old() atau dari user data)
                            if (selectedCityId) {
                                $('#city').val(selectedCityId);
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
                loadCities(provinceId); // Tanpa selectedCityId, karena ini perubahan manual
            });
        });
    </script>
@endpush
