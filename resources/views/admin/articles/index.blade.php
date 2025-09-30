@extends('layouts.admin.master')

@section('articlesActive')
    text-primary
@endsection

@section('content')
    <div class="container">
        <h1><i class="fa-solid fa-eye"></i> Manajemen Portofolio</h1>
        <p class="lead">Kelola daftar portofolio editing yang ditampilkan di website.</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                {{-- Form Pencarian dan Filter Status --}}
                <form action="{{ route('admin.articles.index') }}" method="GET" class="d-flex me-3">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Cari Judul Portofolio..." value="{{ request('search') }}">
                    <select name="status" class="form-select form-select-sm me-2" style="max-width: 150px;">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Published</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        Cari
                    </button>
                    @if (request('search') || request('status') !== null)
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-sm btn-outline-danger ms-2">
                            Reset
                        </a>
                    @endif
                </form>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-sm btn-primary px-3">
                    <i class="fas fa-plus me-1"></i> Tambah Portofolio
                </a>
            </div>

            @if ($articles->isEmpty())
                <div class="alert alert-warning text-center" role="alert">
                    Tidak ada Portofolio yang ditemukan.
                </div>
            @else
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Portofolio</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="servicesTable">
                                    <thead class="table-light">
                                        <tr class="text-center bg-light">
                                            <th>No.</th>
                                            <th>Judul Portofolio</th>
                                            <th>Kategori</th>
                                            <th>Penulis</th>
                                            <th>Status</th>
                                            <th>Dibuat Pada</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($articles as $val)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($articles->currentPage() - 1) * $articles->perPage() }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $val->title }}
                                                    </a>
                                                </td>
                                                <td class="text-center">{{ $val->category->name }}</td>
                                                <td class="text-center">{{ $val->user->name }}</td>
                                                <td class="text-center">
                                                    @if ($val->status)
                                                        <span class="badge bg-primary">Published</span>
                                                    @else
                                                        <span class="badge bg-danger">Draft</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $val->created_at->format('d M Y H:i') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.articles.show', $val->slug) }}"
                                                        class="btn btn-sm btn-info text-white" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.articles.edit', $val->slug) }}"
                                                        class="btn btn-sm btn-success mx-1" title="Edit">
                                                        <i class="fas fa-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.articles.destroy', $val->slug) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus Portofolio ini? Tindakan ini tidak dapat dibatalkan.')">
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
                    {{ $articles->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
