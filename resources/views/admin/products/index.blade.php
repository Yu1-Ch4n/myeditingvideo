@extends('layouts.admin.master')

@section('productsActive')
    text-primary
@endsection

@section('content')
    <div class="container">
        <h1><i class="fa-solid fa-store"></i> Manajemen Produk</h1>
        <p class="lead">Kelola daftar produk editing yang ditampilkan di website.</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                {{-- Form Pencarian dan Filter Status --}}
                <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex me-3">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Cari Judul Produk..." value="{{ request('search') }}">
                    <select name="status" class="form-select form-select-sm me-2" style="max-width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        Cari
                    </button>
                    @if (request('search') || request('status') !== null)
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-danger ms-2">
                            Reset
                        </a>
                    @endif
                </form>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary px-3">
                    <i class="fas fa-plus me-1"></i> Tambah Produk
                </a>

            </div>

            @if ($products->isEmpty())
                <div class="alert alert-warning text-center" role="alert">
                    Tidak ada Produk yang ditemukan.
                </div>
            @else
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Produk</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="servicesTable">
                                    <thead class="table-light">
                                        <tr class="text-center bg-light">
                                            <th>No.</th>
                                            <th>Judul Produk</th>
                                            <th>SKU</th>
                                            <th>Type</th>
                                            <th>Penulis</th>
                                            <th>Status</th>
                                            <th>Dibuat Pada</th>
                                            <th>Harga</th>
                                            <th>Diskon</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $val)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.products.show', $val->slug) }}"
                                                        class="text-decoration-none">
                                                        {{ $val->title }}
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $val->sku }}</td>
                                                <td class="text-center">{{ $val->type->name }}</td>
                                                <td class="text-center">{{ $val->user->name }}</td>
                                                <td class="text-center">
                                                    @if ($val->status)
                                                        <span class="badge bg-primary">Published</span>
                                                    @else
                                                        <span class="badge bg-danger">Draft</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $val->created_at->format('d M Y H:i') }}</td>
                                                <td class="text-center">Rp
                                                    @if ($val->price)
                                                        {{ number_format($val->price, 0, ',', '.') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($val->discount)
                                                        {{ number_format($val->discount, 0, ',', '.') }}%
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">Rp
                                                    @if ($val->price)
                                                        {{ number_format($val->price - ($val->price * $val->discount) / 100, 0, ',', '.') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.products.show', $val->slug) }}"
                                                        class="btn btn-sm btn-info text-white" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.products.edit', $val->slug) }}"
                                                        class="btn btn-sm btn-success mx-1" title="Edit">
                                                        <i class="fas fa-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.products.destroy', $val->slug) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <p id="no-services" class="text-center text-muted mt-4 d-none">Belum ada layanan yang
                                ditambahkan.</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    {{ $products->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
