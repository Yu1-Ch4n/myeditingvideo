@extends('layouts.frontend.master')

@section('title', 'Checkout')

@section('content')
    <section class="container-xl my-5">
        <h2 class="fw-bold mb-4">Checkout</h2>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        {{-- Menampilkan error validasi dari Laravel --}}
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row gx-4">
            {{-- Form Informasi Pengiriman dan Pembayaran --}}
            <div class="col-lg-7 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="mb-3 fw-bold">Detail Pengiriman & Pembayaran</h5>
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="customer_name" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                    id="customer_name" name="customer_name"
                                    value="{{ old('customer_name', $user->name ?? '') }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="customer_email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('customer_email') is-invalid @enderror"
                                    id="customer_email" name="customer_email"
                                    value="{{ old('customer_email', $user->email ?? '') }}" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="customer_phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror"
                                    id="customer_phone" name="customer_phone"
                                    value="{{ old('customer_phone', $user->phone ?? '') }}" required>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="province" class="form-label">Provinsi</label>
                                {{-- KOREKSI: name="shipping_province" --}}
                                <select class="form-select @error('shipping_province') is-invalid @enderror" id="province"
                                    name="shipping_province">
                                    <option value="">Pilih Provinsi</option>
                                    {{-- Opsi provinsi akan dimuat via JavaScript --}}
                                </select>
                                @error('shipping_province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="city" class="form-label">Kota/Kabupaten</label>
                                {{-- KOREKSI: name="shipping_city" --}}
                                <select class="form-select @error('shipping_city') is-invalid @enderror" id="city"
                                    name="shipping_city" disabled>
                                    <option value="">Pilih Kota/Kabupaten</option>
                                    {{-- Opsi kota akan dimuat via JavaScript setelah provinsi dipilih --}}
                                </select>
                                @error('shipping_city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="shipping_address" class="form-label">Alamat Lengkap (Nama Jalan, Nomor Rumah,
                                    RT/RW, Kelurahan, Kecamatan)</label>
                                {{-- KOREKSI: name="shipping_address" --}}
                                <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address"
                                    name="shipping_address" rows="3" required>{{ old('shipping_address', $defaultAddress['address'] ?? '') }}</textarea>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="shipping_postal_code" class="form-label">Kode Pos</label>
                                {{-- Ini sudah benar: name="shipping_postal_code" --}}
                                <input type="text"
                                    class="form-control @error('shipping_postal_code') is-invalid @enderror"
                                    id="shipping_postal_code" name="shipping_postal_code"
                                    value="{{ old('shipping_postal_code', $defaultAddress['postal_code'] ?? '') }}">
                                @error('shipping_postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h5 class="mt-4 mb-3 fw-bold">Metode Pembayaran</h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer"
                                    value="transfer_bank" checked>
                                <label class="form-check-label" for="bank_transfer">
                                    Transfer Bank (BNI, BCA, Mandiri)
                                </label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="radio" name="payment_method" id="midtrans"
                                    value="midtrans">
                                <label class="form-check-label" for="midtrans">
                                    Midtrans (Kartu Kredit, E-wallet, dll.)
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Bayar Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Pesanan --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h5 class="mb-3 fw-bold">Ringkasan Pesanan</h5>
                        <ul class="list-group list-group-flush mb-3">
                            @foreach ($cartItems as $item)
                                @if ($item->product)
                                    <li
                                        class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                        <div>
                                            <h6 class="mb-0">{{ $item->product->title }}</h6>
                                            <small class="text-muted">{{ $item->quantity }} x
                                                Rp{{ number_format($item->price_at_add, 0, ',', '.') }}</small>
                                        </div>
                                        @php
                                            $itemPrice = $item->price_at_add;
                                            $finalItemPrice = $itemPrice;
                                            if ($item->discount_at_add > 0) {
                                                $discountAmountPerUnit = $itemPrice * $item->discount_at_add;
                                                $finalItemPrice = $itemPrice - $discountAmountPerUnit;
                                            }
                                        @endphp
                                        <span
                                            class="fw-semibold">Rp{{ number_format($itemPrice * $item->quantity, 0, ',', '.') }}</span>
                                    </li>
                                @endif
                            @endforeach
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 mt-2">
                                Subtotal Barang:
                                <span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                Diskon:
                                <span class="text-danger">-Rp{{ number_format($totalDiscount, 0, ',', '.') }}</span>
                            </li>
                            <li
                                class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 fw-bold">
                                Total Pembayaran:
                                <span class="fs-5 text-success">Rp{{ number_format($total, 0, ',', '.') }}</span>
                            </li>
                        </ul>
                        <p class="text-muted small text-center mt-3">Dengan menekan "Bayar Sekarang", Anda menyetujui
                            Syarat dan Ketentuan kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Simpan nilai provinsi dan kota pengguna yang sudah ada
            // Perbarui ini juga untuk menggunakan nama input yang baru jika Anda menyimpannya di DB
            const userProvinceId = "{{ old('shipping_province', $user->province ?? '') }}";
            const userCityId = "{{ old('shipping_city', $user->city ?? '') }}";

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
                                loadCities(userProvinceId);
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
