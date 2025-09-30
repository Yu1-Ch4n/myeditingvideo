@extends('layouts.frontend.master')

@section('title', 'Checkout Berhasil')

@section('content')
    <section class="container-xl my-5 text-center">
        <div class="card shadow-lg border-0 p-5 mx-auto" style="max-width: 700px;">
            <div class="card-body">
                <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                <h2 class="fw-bold mt-3 mb-2 text-success">Pesanan Berhasil Dibuat!</h2>
                <p class="lead mb-4">Terima kasih telah berbelanja di toko kami. Pesanan Anda dengan nomor
                    **#{{ $order->order_number }}** telah berhasil diproses.</p>
                <p class="mb-2">Total Pembayaran: <span
                        class="fw-bold text-success">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </p>
                <p class="mb-4">Metode Pembayaran: <span
                        class="fw-bold">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></p>

                <p class="mb-4">Kami akan segera mengirimkan konfirmasi detail pesanan ke email Anda
                    ({{ $order->customer_email }}).</p>

                <div class="d-grid gap-2 col-md-8 mx-auto">
                    <a href="{{ route('home.products.index') }}" class="btn btn-primary btn-lg">Lanjut Belanja</a>
                    {{-- Tambahkan link ke halaman riwayat pesanan jika ada --}}
                    {{-- @auth
                        <a href="{{ route('user.orders') }}" class="btn btn-outline-secondary btn-lg">Lihat Riwayat Pesanan</a>
                    @endauth --}}
                </div>
            </div>
        </div>
    </section>
@endsection
