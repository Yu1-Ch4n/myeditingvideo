@extends('layouts.frontend.master')

@section('homeActive')
    active
@endsection

@section('content')
    @if (session('error'))
        <div
            style="background-color: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif
    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto">
                    <h1>Ubah Ide Anda Menjadi Karya Visual Memukau</h1>
                    <p class="lead">Kami menyediakan jasa editing video profesional untuk berbagai kebutuhan, dari
                        promosi bisnis hingga konten pribadi. Cepat, Kreatif, dan Berkualitas Tinggi.</p>
                    <a class="btn btn-outline-primary me-3"nav-link @yield('articlesActive')
                        href="{{ route('home.articles.index') }}">{{ __('Lihat Portofolio') }}</a>
                    <a class="btn btn-primary @yield('contactActive')"
                        href="{{ route('home.contact.index') }}">{{ __('Kontak') }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <h2 class="section-title">Layanan Kami</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-film service-icon"></i>
                            <h5 class="card-title">Video Promosi & Iklan</h5>
                            <p class="card-text">Buat video promosi yang menarik untuk produk, layanan, atau acara Anda.
                                Kami bantu tingkatkan brand awareness.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-photo-video service-icon"></i>
                            <h5 class="card-title">Konten Media Sosial</h5>
                            <p class="card-text">Optimalkan kehadiran Anda di media sosial dengan video pendek, reel,
                                atau story yang viral dan menarik perhatian.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-graduation-cap service-icon"></i>
                            <h5 class="card-title">Video Edukasi & Tutorial</h5>
                            <p class="card-text">Jelaskan konsep kompleks dengan mudah melalui video edukasi yang
                                informatif dan menarik untuk audiens Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-camera service-icon"></i>
                            <h5 class="card-title">Video Dokumenter & Event</h5>
                            <p class="card-text">Abadikan momen penting dalam hidup atau acara spesial Anda dengan
                                editing video yang berkesan dan profesional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-cut service-icon"></i>
                            <h5 class="card-title">Color Grading & Sound Design</h5>
                            <p class="card-text">Tingkatkan kualitas visual dan audio video Anda dengan color grading
                                profesional dan sound design yang imersif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card text-center h-100">
                        <div class="card-body">
                            <i class="fas fa-magic service-icon"></i>
                            <h5 class="card-title">Motion Graphics & VFX</h5>
                            <p class="card-text">Tambahkan elemen visual dinamis dan efek khusus yang menakjubkan untuk
                                membuat video Anda lebih hidup.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portofolio Section -->
    <section id="hasil" class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title">Portofolio Kami</h2>
            <div class="row g-4">
                @forelse ($articles as $key => $val)
                    <div class="col-md-6 col-lg-4">
                        <div class="card shadow-sm border-0 h-100 mb-3">
                            @if ($val->image)
                                <div class="ratio ratio-16x9">
                                    <img class="card-img-top" src="{{ asset('storage/' . $val->image) }}"
                                        alt="Gambar Portofolio: {{ $val->title }}">
                                </div>
                            @else
                                <div class="card-img-top d-flex align-items-center justify-content-center text-white-50 ratio ratio-16x9"
                                    style=" background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
                                    Image not available
                                </div>
                            @endif
                            <div class="card-body small d-flex flex-column text-center">
                                <h5 class="card-title"><small>{{ $val->title }}</small></h5>
                                <p>{{ $val->category->name }}</p>
                                <a href="{{ route('home.articles.show', $val->slug) }}"
                                    class="btn btn-sm btn-primary mt-1 rounded-pill">Lihat Portofolio</a>
                            </div>
                            <div class="card-footer text-center">
                                <small class="text-muted">Diperbaharui:
                                    {{ $val->updated_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center" role="alert">
                            Belum ada artikel yang tersedia.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <h2 class="section-title">Apa Kata Klien Kami</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="testimonial-card text-center">
                                    <p class="quote">"Sangat puas dengan hasil editingnya! Video promosi saya jadi
                                        terlihat sangat profesional dan menarik. Komunikasi juga lancar dan responsif."
                                    </p>
                                    <p class="author">- Budi Santoso, Pemilik UMKM</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="testimonial-card text-center">
                                    <p class="quote">"Tim ini luar biasa! Mereka berhasil menangkap esensi acara saya
                                        dan mengubahnya menjadi video dokumenter yang mengharukan. Rekomendasi sekali!"
                                    </p>
                                    <p class="author">- Siti Aminah, Penyelenggara Event</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="testimonial-card text-center">
                                    <p class="quote">"Video tutorial saya jadi mudah dipahami berkat editing yang rapi
                                        dan penambahan motion graphics yang keren. Pasti akan menggunakan jasa mereka
                                        lagi!"</p>
                                    <p class="author">- David Lee, Content Creator</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
