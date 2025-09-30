@extends('layouts.admin.master')
@section('ordersActive')
    text-primary
@endsection


@section('content')
    <h1 class="mb-4" style="font-size:x-large">Detail Pesanan #{{ $order->order_number }}</h1>
    <hr>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pesanan</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nomor Order:</strong> {{ $order->order_number }}</p>
                    <p><strong>Total Jumlah:</strong> Rp{{ number_format($order->total_amount, 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> <span
                            class="badge {{ $order->status == 'pending' ? 'bg-warning' : ($order->status == 'processing' ? 'bg-info' : ($order->status == 'completed' ? 'bg-success' : 'bg-danger')) }}">{{ ucfirst($order->status) }}</span>
                    </p>
                    <p><strong>Status Pembayaran:</strong> <span
                            class="badge {{ $order->payment_status == 'pending' ? 'bg-warning' : ($order->payment_status == 'paid' ? 'bg-success' : 'bg-danger') }}">{{ ucfirst($order->payment_status) }}</span>
                    </p>
                    <p><strong>Metode Pembayaran:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <p><strong>Tanggal Pesanan:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

                    <h6 class="mt-4 font-weight-bold text-primary">Informasi Pelanggan</h6>
                    <p><strong>Nama:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                    <p><strong>Telepon:</strong> {{ $order->customer_phone }}</p>
                    <p><strong>Alamat Pengiriman:</strong> {{ $order->shipping_address }}, {{ $order->shipping_city }},
                        {{ $order->shipping_province }} {{ $order->shipping_postal_code }}</p>

                    <h6 class="mt-4 font-weight-bold text-primary">Item Pesanan</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>SKU</th>
                                    <th>Jumlah</th>
                                    <th>Harga Per Unit</th>
                                    <th>Diskon Per Unit</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->product_sku }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp{{ number_format($item->price_per_unit, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format(($item->discount_per_unit * $item->price_per_unit) / 100, 0, ',', '.') }}
                                        </td>
                                        <td>Rp{{ number_format($item->price_per_unit * (1 - $item->discount_per_unit / 100) * $item->quantity, 0, ',', '.') }}
                                        </td>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>



                    </div>

                </div>

            </div>
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Produk
                </a>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Status Pesanan</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Pesanan</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                                <option value="refunded" {{ $order->status == 'refunded' ? 'selected' : '' }}>Refunded
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_status" class="form-label">Status Pembayaran</label>
                            <select class="form-control" id="payment_status" name="payment_status">
                                <option value="pending" {{ $order->payment_status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                </option>
                                <option value="failed" {{ $order->payment_status == 'failed' ? 'selected' : '' }}>Failed
                                </option>
                                <option value="refunded" {{ $order->payment_status == 'refunded' ? 'selected' : '' }}>
                                    Refunded</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Perbarui Status</button>
                    </form>

                    <hr class="my-4">

                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini? Aksi ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Hapus Pesanan</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection
