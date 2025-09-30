@extends('layouts.frontend.master')

@section('productsActive')
    active
@endsection

@section('content')
    <!-- Header Section -->
    <header class="text-white text-center py-4"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <h2 class="fw-bold mt-2">Daftar Produk</h2>
            <p>Lihatlah produk yang kami sediakan!</p>
        </div>
    </header>

    <!-- Main Content Section -->
    <section class="container-xl my-5">
        <div class="row gx-4">
            <div class="col-lg-9">
                <div class="row">
                    @forelse ($products as $key => $val)
                        <div class="col-md-12 mb-3">
                            <div class="card shadow-sm border-0">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        @if ($val->image)
                                            <img class="img-fluid" style="height: 100%"
                                                src="{{ asset('storage/' . $val->image) }}"
                                                alt="Gambar Produk: {{ $val->title }}">
                                        @else
                                            <div class="img-fluid d-flex align-items-center justify-content-center text-white-50"
                                                style=" height: 100%; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
                                                Image not available
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body py-2 small">
                                            <h5 class="card-title mt-2"><small>{{ $val->title }}</small></h5>
                                            <span
                                                class="text-dark">{{ Str::limit(strip_tags($val->meta_desc), 150) }}</span>
                                            <hr class="mb-2">
                                            <div class="d-flex justify-content-between align-items-center">

                                                @php
                                                    $finalPrice = $val->price;
                                                    $discountPercentage = $val->discount;
                                                    if ($val->discount > 0) {
                                                        $discountAmount = $val->price * $discountPercentage;
                                                        $finalPrice = $val->price - $discountAmount;
                                                    }

                                                    // --- Data Dummy Rating ---
                                                    // Ganti ini dengan logika pengambilan rating aktual dari database Anda
                                                    $averageRating = 0; // Misalnya, $val->reviews->avg('rating');
                                                    $totalReviews = 0; // Misalnya, $val->reviews->count();

                                                    // Untuk tujuan demo, kita bisa set rating manual atau secara acak
                                                    // Misalnya, jika $val->id adalah ganjil, beri rating 4.5, genap 3.8
                                                    if ($val->id % 2 == 1) {
                                                        $averageRating = 4.5;
                                                        $totalReviews = 12;
                                                    } else {
                                                        $averageRating = 3.8;
                                                        $totalReviews = 7;
                                                    }
                                                    // --- End Data Dummy Rating ---
                                                @endphp

                                                @if ($val->discount > 0)
                                                    <p class="card-text mb-0">
                                                        <span class="badge bg-danger me-1">
                                                            @if ($val->discount)
                                                                {{ number_format($val->discount, 0, ',', '.') }}%
                                                            @else
                                                                -
                                                            @endif
                                                            OFF
                                                        </span>
                                                        <s class="text-muted small">Rp
                                                            @if ($val->price)
                                                                {{ number_format($val->price, 0, ',', '.') }}
                                                            @else
                                                                -
                                                            @endif
                                                        </s>
                                                    </p>
                                                    <p class="card-text text-success fw-bold fs-5 mb-2">Rp
                                                        {{ number_format($val->price - ($val->price * $val->discount) / 100, 0, ',', '.') }}
                                                    @else
                                                        -
                                                @endif
                                                <hr class="my-2">
                                                <div class="d-flex align-items-center"> {{-- Container untuk rating --}}
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($averageRating >= $i)
                                                            <i class="bi bi-star-fill text-warning small"></i>
                                                        @elseif ($averageRating >= $i - 0.5)
                                                            <i class="bi bi-star-half text-warning small"></i>
                                                        @else
                                                            <i class="bi bi-star text-muted small"></i>
                                                        @endif
                                                    @endfor
                                                    @if ($totalReviews > 0)
                                                        <span
                                                            class="ms-2 text-muted small">({{ number_format($averageRating, 1) }})</span>
                                                        <span class="ms-1 text-muted small">({{ $totalReviews }})</span>
                                                    @else
                                                        <span class="ms-2 text-muted small">(Belum ada rating)</span>
                                                    @endif
                                                </div>
                                                <a href="{{ route('home.products.show', $val->slug) }}"
                                                    class="btn btn-primary btn-sm stretched-link">Lihat Produk</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                Belum ada Produk yang tersedia.
                            </div>
                        </div>
                    @endforelse
                </div>
                <br>
                <div class="row">
                    <div class="d-flex justify-content-center">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>

            <!-- sidebar -->
            @include('home.products.sidebar')

        </div>
    </section>
@endsection
