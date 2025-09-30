@extends('layouts.admin.master')

@section('ordersActive')
    text-primary
@endsection

@section('content')
    <div class="header">
        <div class="container">
            <h1><i class="fa-solid fa-cart-flatbed"></i> Managemen Pesanan</h1>
            <p class="lead">Kelola Permintaan Jasa Editing yang Masuk</p>
        </div>
    </div>
    <br>



    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Pesanan Masuk</h4>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="servicesTable">
                        <thead class="table-light">
                            <tr>
                                <th>No. Order</th>
                                <th>Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer_name }}</td>
                                    <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td><span
                                            class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'processing' ? 'bg-info' : ($order->status == 'completed' ? 'bg-success' : 'bg-danger')) }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td><span
                                            class="badge {{ $order->payment_status == 'pending' ? 'bg-warning' : ($order->payment_status == 'paid' ? 'bg-success' : 'bg-danger') }}">{{ ucfirst($order->payment_status) }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="btn btn-sm btn-info">Detail</a>
                                        {{-- Tombol hapus bisa ditambahkan di sini atau di halaman detail --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p id="no-services" class="text-center text-muted mt-4 d-none">Belum ada layanan yang ditambahkan.</p>
            </div>
        </div>
    </div>
@endsection
