@extends('layouts.admin.master')

@section('productsActive')
    text-primary
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="card-title mb-3 text-center" style="font-size: 2rem; font-weight: 700;">{{ $product->title }}</h1>
            <div class="card shadow-sm border-0 rounded-lg"> {{-- Menambahkan shadow dan border-0 untuk tampilan modern --}}

                <div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl">
                    <div class="bg-white shadow-lg rounded-xl p-6 md:p-8">
                        <h2 class="pt-5 text-center" style="font-size: 2rem; font-weight: 700;">Product Details</h2>
                        @if ($product->image)
                            {{-- Jika ada gambar Produk, tampilkan gambar tersebut --}}
                            <div class="col-lg-6 mx-auto my-5">
                                <img class="card-img-top object-fit-cover rounded-top"
                                    src="{{ asset('storage/' . $product->image) }}"
                                    alt="Gambar Produk: {{ $product->title }}">
                            </div>
                        @else
                            {{-- Jika gambar Produk null, tampilkan gambar dummy --}}
                            <div class="ratio ratio-21x9 col-lg-6 mx-auto my-5"
                                style="background: linear-gradient(rgba(25, 135, 84, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
                                <h1 class="text-white ms-lg-5 ms-3" style="margin-top: 18%"><b>MyEditingVideo</b> <br>
                                    <small>Aplikasi Jasa Editing Terbaik</small>
                                </h1>
                            </div>
                        @endif


                        <div class="overflow-x-auto rounded-lg border border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Penulis (Author) -->
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700 w-1/3">
                                            <i class="fas fa-user mr-2 text-gray-500 mx-3"></i>Penulis:
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-semibold w-2/3">
                                            {{ $product->user->name }}
                                        </td>
                                    </tr>
                                    <!-- Type -->
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700">
                                            <i class="fas fa-tag mr-2 text-gray-500 mx-3"></i>Type:
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            {{ $product->type->name }}
                                        </td>
                                    </tr>
                                    <!-- Dibuat (Created At) -->
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700">
                                            <i class="fas fa-calendar-alt mr-2 text-gray-500 mx-3"></i>Dibuat:
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                            {{ $product->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                    <!-- Harga (Price) -->
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700">
                                            <i class="fas fa-calendar-check mr-2 text-gray-500 mx-3"></i>Harga:
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <!-- Diskon (Discount) -->
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700">
                                            <i class="fas fa-tags mr-2 text-gray-500 mx-3"></i>Diskon:
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            {{ number_format($product->discount, 0, ',', '.') }}%
                                        </td>
                                    </tr>
                                    <!-- Harga Setelah Diskon (Price After Discount) -->
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700">
                                            <i class="fas fa-money-bill-wave mr-2 text-gray-500 mx-3"></i>Harga Setelah
                                            Diskon:
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                            Rp
                                            {{ number_format($product->price - ($product->price * $product->discount) / 100, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <!-- Status -->
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-700">
                                            <i class="fas fa-info-circle mr-2 text-gray-500 mx-3"></i>Status:
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                                            <span>
                                                @if ($product->status)
                                                    <span class="badge bg-primary">Published</span>
                                                @else
                                                    <span class="badge bg-danger">Draft</span>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr class="my-3">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Produk
                    </a>
                    @if (Auth::check() && (Auth::user()->id === $product->user_id || Auth::user()->isAdmin()))
                        <div>
                            <a href="{{ route('admin.products.edit', $product->slug) }}"
                                class="btn btn-warning text-white me-2">
                                <i class="fas fa-edit me-2"></i> Edit Produk
                            </a>
                            <form action="{{ route('admin.products.destroy', $product->slug) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus Produk ini? Tindakan ini tidak dapat dibatalkan.')">
                                    <i class="fas fa-trash-alt me-2"></i> Hapus Produk
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
