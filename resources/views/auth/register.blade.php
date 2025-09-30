<!doctype html>
<html lang="en">

<head>
    @include('layouts.frontend.head')
    @include('layouts.frontend.style')
    @vite([])
</head>

<body>
    <main class="flex-grow-1 py-5">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-8 col-lg-8 col-xl-8">
                    <div class="card shadow px-4 py-4">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-video pe-3"></i>
                                <span>MyEditingVideo : Register</span>
                            </h2>
                            <hr>
                            <p class="text-center text-muted mb-4">Daftar Akun Baru</p>

                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- Name -->
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input id="name" type="text" name="name" value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror" required autofocus
                                            autocomplete="name">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email Address -->
                                    <div class="col-lg-6 mb-3">
                                        <label for="email" class="form-label">Alamat Email</label>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror" required
                                            autocomplete="username">
                                        @error('email')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="col-lg-6 mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror" required
                                            autocomplete="new-password">
                                        @error('password')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-lg-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi
                                            Password</label>
                                        <input id="password_confirmation" type="password" name="password_confirmation"
                                            class="form-control" required autocomplete="new-password">
                                    </div>

                                    <!-- Gender -->
                                    <div class="col-lg-6 mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select id="gender" name="gender"
                                            class="form-select @error('gender') is-invalid @enderror">
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki"
                                                {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>
                                                Laki-laki</option>
                                            <option value="Perempuan"
                                                {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>
                                                Perempuan</option>
                                            <option value="Lainnya" {{ old('gender') == 'Lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                        @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-lg-6 mb-3">
                                        <label for="phone" class="form-label">Nomor Telepon</label>
                                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                            class="form-control @error('phone') is-invalid @enderror" required
                                            autocomplete="tel">
                                        @error('phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Instagram -->
                                    <div class="col-lg-6 mb-3">
                                        <label for="instagram" class="form-label">Username Instagram (Opsional)</label>
                                        <input id="instagram" type="text" name="instagram"
                                            value="{{ old('instagram') }}"
                                            class="form-control @error('instagram') is-invalid @enderror"
                                            autocomplete="off">
                                        @error('instagram')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Image Upload -->
                                    <div class="col-lg-6 mb-3">
                                        <label for="image" class="form-label">Unggah Foto Profil (Opsional)</label>
                                        <input id="image" type="file" name="image"
                                            class="form-control @error('image') is-invalid @enderror">
                                        @error('image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end align-items-center mt-4">
                                        <a class="text-decoration-underline text-muted me-3"
                                            href="{{ route('login') }}">
                                            Sudah punya akun?
                                        </a>

                                        <button type="submit" class="btn btn-primary">
                                            Daftar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            <div class="text-center text-secondary mt-3">
                                Kembali ke halaman <a href="/" tabindex="-1">Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('layouts.frontend.script')

</body>

</html>
