@extends('layouts.admin.master')

@section('typesActive')
    text-primary
@endsection

@section('content')
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
        aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.types.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
        </ol>
    </nav>
    <hr><br>

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Data Kategori
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.types.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Buat Kategori</button>
                        <a href="{{ route('admin.types.index') }}" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
