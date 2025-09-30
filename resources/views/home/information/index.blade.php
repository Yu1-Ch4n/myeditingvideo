@extends('layouts.frontend.master')

@section('informationActive')
    active
@endsection

@section('content')
    <!-- Header Section -->
    <header class="text-white text-center py-4"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <h2 class="fw-bold mt-2">Daftar Informasi</h2>
            <p>Bacalah informasi tentang produk kami!</p>
        </div>
    </header>

    <!-- Main Content Section -->
    <section class="container-xl my-5">
        <div class="row gx-4">
            <div class="col-lg-9">
                <div class="card card-body shadow-sm border-0 shadow-sm border-0 small p-4">
                    @forelse ($information as $key => $val)
                        <div class="col-12 mb-1">
                            <a href="{{ route('home.information.show', $val->slug) }}" class="text-decoration-none">
                                <h5 class="fw-bold"><small>{{ $val->title }}</small></h5>
                            </a>
                            <p class="text-dark">{{ Str::limit(strip_tags($val->content), 250) }}</p>
                            <hr>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                Belum ada Informasi yang tersedia.
                            </div>
                        </div>
                    @endforelse
                </div>
                <br>
                <div class="d-flex justify-content-center">
                    {{ $information->links('pagination::bootstrap-4') }}
                </div>
            </div>

            <!-- sidebar -->
            @include('home.information.sidebar')

        </div>
    </section>
@endsection
