@extends('layouts.admin.master')

@section('categoriesActive')
    text-primary
@endsection

@section('content')
    <div class="container">
        <h1><i class="fa-solid fa-icons"></i> Manajemen Kategori</h1>
        <p class="lead">Kelola daftar kategori editing yang ditampilkan di website.</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                {{-- Form Pencarian --}}
                <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex me-3">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Cari Kategori..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        Cari
                    </button>
                    @if (request('search') !== null)
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-outline-danger ms-2">
                            Reset
                        </a>
                    @endif
                </form>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-primary px-3">
                    <i class="fas fa-plus me-1"></i> Tambah Kategori
                </a>
            </div>

            <div class="row gx-4">
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Kategori</h4>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                @if ($categories->isEmpty())
                                    <div class="alert alert-warning text-center" role="alert">
                                        Tidak ada kategori yang ditemukan.
                                    </div>
                                @else
                                    <table class="table table-hover align-middle" id="servicesTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th class= "text-center">Kategori</th>
                                                <th class= "text-center">Jumlah</th>
                                                <th class= "text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="servicesList">
                                            @foreach ($categories as $val)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                                    </td>
                                                    <td class="text-center">{{ $val->name }}</td>
                                                    <td class= "text-center">{{ $val->articles->count() }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.categories.edit', $val->id) }}"
                                                            class="btn btn-sm btn-success">
                                                            <i class="fas fa-pencil"></i>
                                                        </a>
                                                        <form action="{{ route('admin.categories.destroy', $val->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus Kategori ini? Tindakan ini tidak dapat dibatalkan.')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-flex justify-content-end">
                                        {{ $categories->links('pagination::bootstrap-4') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            Grafik Artikel
                        </div>
                        <div class="card-body">
                            <div id="myChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        var options = {
            chart: {
                type: 'donut',
                fontFamily: 'inherit',
                height: 300,
            },
            series: [
                @foreach ($categories as $val)
                    {{ $val->articles->count() }},
                @endforeach
            ],
            labels: [
                @foreach ($categories as $val)
                    "{{ $val->name }}",
                @endforeach
            ],
            dataLabels: {
                enabled: false
            },
        };

        var chart = new ApexCharts(document.querySelector("#myChart"), options);
        chart.render();
    </script>
@endpush
