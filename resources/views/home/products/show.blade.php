@extends('layouts.frontend.master')

@section('title', $product->title . ' - Detail Produk')

@section('content')
    <section class="container-xl mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home.products.index') }}" class="text-decoration-none">Daftar
                        Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->title, 50) }}</li>

            </ol>
        </nav>
    </section>

    <section class="container-xl my-4">
        {{-- Menampilkan pesan sukses --}}
        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Menampilkan pesan error --}}
        @if (Session::has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ Session::get('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row gx-4">
            <div class="col-lg-12 mb-3">
                <div class="card card-body shadow-sm border-0 p-4 mb-4">
                    <div class="row gx-5">
                        {{-- Gambar Produk --}}
                        <div class="col-lg-4">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded"
                                    alt="{{ $product->title }}">
                            @else
                                <div class="img-fluid d-flex align-items-center justify-content-center text-white-50"
                                    style=" height: 100%; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
                                    Image not available
                                </div>
                            @endif
                        </div>

                        {{-- Detail Produk dan Aksi --}}
                        <div class="col-lg-8">

                            <h1 class="h3 fw-bold mb-2">{{ $product->title }}</h1>
                            <p class="text-muted small mb-3">SKU: {{ $product->sku ?? 'N/A' }} | Dilihat: XX</p>

                            @php
                                $finalPrice = $product->price;
                                // Asumsi $product->discount adalah desimal (e.g., 0.1 untuk 10%)
                                $discountPercentage = $product->discount;
                                if ($product->discount > 0) {
                                    $discountAmount = $product->price * $discountPercentage;
                                    $finalPrice = $product->price - $discountAmount;
                                }
                            @endphp


                            {{-- Harga Produk --}}
                            {{-- menampilkan diskon --}}
                            @if ($product->discount > 0)
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge bg-danger fs-6 me-2">
                                        @if ($product->discount)
                                            {{ number_format($product->discount, 0, ',', '.') }}%
                                        @else
                                            -
                                        @endif
                                        OFF
                                    </span>
                                    <s class="text-muted fs-6">Rp{{ number_format($product->price, 0, ',', '.') }}</s>
                                </div>
                                {{-- Menampilkan harga setelah diskon --}}
                                <h2 class="text-success fw-bold display-5 mb-3">
                                    Rp{{ number_format($product->price - ($product->price * $product->discount) / 100, 0, ',', '.') }}
                                </h2>
                            @else
                                <h2 class="text-success fw-bold display-5 mb-3">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </h2>
                            @endif

                            <div class="mb-3">
                                <div class="text-break">
                                    {{ $product->description }}
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <p class="fw-semibold mb-1">Stok:</p>
                                    <span
                                        class="badge {{ $product->stock > 0 ? 'bg-info' : 'bg-danger' }} fs-6">{{ $product->stock > 0 ? $product->stock . ' Tersedia' : 'Stok Habis' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <p class="fw-semibold mb-1">Type Produk:</p>
                                    <span class="badge bg-secondary fs-6">{{ $product->type->name ?? 'Tidak Ada' }}</span>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="d-flex gap-2 mt-4">
                                    {{-- KOREKSI UTAMA ADA DI SINI: action form mengarah ke cart.add --}}
                                    <form action="{{ route('cart.add', $product->slug) }}" method="POST"
                                        class="flex-grow-1">
                                        @csrf
                                        {{-- Anda mungkin ingin menambahkan input kuantitas di sini jika tidak selalu 1 --}}
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-success py-3 w-100"
                                            @if ($product->stock == 0) disabled @endif>
                                            <i class="bi bi-cart-plus me-2"></i>
                                            {{ $product->stock == 0 ? 'Stok Habis' : 'Tambahkan ke Keranjang' }}
                                        </button>
                                    </form>
                                    <a href="{{ route('checkout.index') }}" class="btn btn-primary flex-grow-1 py-3">
                                        <i class="bi bi-bag-check me-2"></i> Beli Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('home.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Produk
                </a>
            </div>
        </div>
    </section>
@endsection
