@extends('layouts.admin.master')

@section('usersActive')
    text-primary
@endsection

@section('content')
    <div class="container">
        <h1><i class="fa-solid fa-person"></i> Managenen Pengguna</h1>
        <p class="lead">Kelola daftar pengguna yang ada.</p>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                {{-- Form Pencarian --}}
                <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex me-3">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Cari Pengguna..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        Cari
                    </button>
                    @if (request('search') !== null)
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-danger ms-2">
                            Reset
                        </a>
                    @endif
                </form>

                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary px-3">
                    <i class="fas fa-plus me-1"></i> Tambah Pengguna
                </a>
            </div>

            @if ($users->isEmpty())
                <div class="alert alert-warning text-center" role="alert">
                    Tidak ada pengguna yang ditemukan.
                </div>
            @else
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="fas fa-list"></i> Daftar Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle" id="servicesTable">
                                    <thead class="table-light">
                                        <tr class="text-center">
                                            <th>No.</th>
                                            <th>Nama</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                                </td>
                                                <td class="text-center">{{ $user->name }}</td>
                                                <td class="text-center">{{ $user->gender }}</td>
                                                <td class="text-center">{{ $user->email }}</td>
                                                <td class="text-center">{{ $user->phone }}</td>
                                                <td class="text-center"><span
                                                        class="badge {{ $user->isUser() ? 'bg-danger' : 'bg-primary' }}">{{ Str::ucfirst($user->role) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-success">
                                                        <i class="fas fa-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini? Tindakan ini tidak dapat dibatalkan.')">
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
                    {{ $users->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                </div>
            @endif
        </div>
    </div>
@endsection
