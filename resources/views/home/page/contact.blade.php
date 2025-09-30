@extends('layouts.frontend.master')

@section('contactActive')
    active
@endsection

@section('content')
    <header class="text-white text-center py-4"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <h2 class="fw-bold mt-2">Kontak Kami</h2>
            <p>Kami siap membantu Anda. Jangan ragu untuk menghubungi kami!</p>
        </div>
    </header>

    <section class="container-xl my-5">
        <div class="row gx-4">
            <div class="col-lg-6 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body m-3">
                        <h5>Kantor Kami</h5>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <div class="ratio ratio-16x9">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col">
                                <h5 class="mb-3">Detail Kontak</h5>
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-1"><i class="fas fa-map-marker-alt text-primary me-2"></i> Kp. Pasir
                                        Leutik. RT 01 Rw 08, Ciheulang Ciparay</li>
                                    <li class="mb-1"><i class="fas fa-phone-alt text-primary me-2"></i> +62 831-7129-9243
                                    </li>
                                    <li class="mb-1"><i class="fas fa-envelope text-primary me-2"></i>
                                        myeditingvideo@gmail.com
                                    </li>
                                    <li class="mb-1"><i class="fas fa-clock text-primary me-2"></i> Senin - Jumat: 09:00 -
                                        17:00 WIB
                                    </li>
                                </ul>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body m-3">
                        <h5>Kirim Pesan Kepada Kami</h5>
                        <hr>

                        {{-- Menampilkan pesan sukses --}}
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ Session::get('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Menampilkan pesan error --}}
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ Session::get('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        {{-- Form untuk mengirim pesan kontak --}}
                        <form action="{{ route('home.contact.store') }}" method="POST" id="contactForm">
                            @csrf {{-- Token CSRF untuk keamanan --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Masukkan nama lengkap Anda"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="nama@contoh.com" value="{{ old('email') }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subjek</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                    id="subject" name="subject" placeholder="Subjek pesan Anda"
                                    value="{{ old('subject') }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan Anda</label>
                                <textarea class="form-control @error('message') is-invalid @enderror" id="message" name="message" rows="6"
                                    placeholder="Tulis pesan Anda di sini..." required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- kotak ceklis untuk recaptcha --}}
                            <div class="g-recaptcha mt-4" data-sitekey="{{ config('services.recaptcha.key') }}">
                            </div>
                            @error('g-recaptcha-response')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror

                            <button type="submit" class="btn btn-primary w-100 py-2 mt-3">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([-7.022448671310791, 107.67932210073619], 15);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        L.marker([-7.022448671310791, 107.67932210073619]).addTo(map)
            .bindPopup('Our Office')
            .openPopup();
    </script>
    {{-- Script reCAPTCHA --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endpush
