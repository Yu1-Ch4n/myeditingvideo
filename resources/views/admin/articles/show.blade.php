@extends('layouts.admin.master')

@section('articlesActive')
    text-primary
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0 rounded-lg"> {{-- Menambahkan shadow dan border-0 untuk tampilan modern --}}
                @if ($article->image)
                    {{-- Jika ada gambar artikel, tampilkan gambar tersebut --}}
                    <div class="ratio ratio-21x9">
                        <img class="card-img-top object-fit-cover rounded-top" src="{{ asset('storage/' . $article->image) }}"
                            alt="Gambar Artikel: {{ $article->title }}">
                    </div>
                @else
                    {{-- Jika gambar artikel null, tampilkan gambar dummy --}}
                    <div class="ratio ratio-21x9 rounded-top d-flex align-items-center"
                        style="background: linear-gradient(rgba(25, 135, 84, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
                        <h1 class="text-white ms-lg-5 ms-3" style="margin-top: 18%"><b>MyEditingVideo</b> <br>
                            <small>Aplikasi Jasa Editing Terbaik</small>
                        </h1>
                    </div>
                @endif
                <div class="card-body p-4 p-md-5"> {{-- Menambah padding untuk tampilan yang lebih luas --}}
                    <h1 class="card-title mb-3" style="font-size: 2rem; font-weight: 700;">{{ $article->title }}</h1>
                    <div class="text-muted mb-4 d-flex flex-wrap align-items-center small"> {{-- Mengurangi ukuran font meta --}}
                        <span class="me-3">
                            <i class="fas fa-user me-1"></i> Penulis: <strong>{{ $article->user->name }}</strong>
                        </span>
                        <span class="me-3">
                            <i class="fas fa-tag me-1"></i> Kategori: <strong>{{ $article->category->name }}</strong>
                        </span>
                        <span class="me-3">
                            <i class="fas fa-calendar-alt me-1"></i> Dibuat: {{ $article->created_at->format('d M Y H:i') }}
                        </span>
                        <span>
                            <i class="fas fa-info-circle me-1"></i> Status:
                            @if ($article->status)
                                <span class="badge bg-primary">Published</span>
                            @else
                                <span class="badge bg-danger">Draft</span>
                            @endif
                        </span>
                    </div>

                    <hr class="my-3">

                    <div class="note-editable mt-4" style="font-size: 1rem; line-height: 1.5;">
                        {!! $article->content !!}
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Artikel
                        </a>
                        @if (Auth::check() && (Auth::user()->id === $article->user_id || Auth::user()->isAdmin()))
                            <div>
                                <a href="{{ route('admin.articles.edit', $article->slug) }}"
                                    class="btn btn-warning text-white me-2">
                                    <i class="fas fa-edit me-2"></i> Edit Artikel
                                </a>
                                <form action="{{ route('admin.articles.destroy', $article->slug) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.')">
                                        <i class="fas fa-trash-alt me-2"></i> Hapus Artikel
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
