@extends('layouts.frontend.master')

@section('teamActive')
    active
@endsection

@section('content')
    <header class="text-white text-center py-4"
        style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(13, 110, 253, 0.7)), url('https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjABnDbemIZRqgw-4TD-9aYQlFnji4B3Dhp7plh8HFpvcK5zQf6YUIS9aObSDOJMYHg6_ZYERA_dD7f1TJdp1foazKYTtx8JpLOMjHw749Ftbh20WyryWuCiTAMm7LLCkr7PIvyLBJP-g0E2jFTqF63zGaCHJoFcJBzRhdHWmNOblZfV6C1Vf9-l2gNwl8/w0/64dc1ed3a926ddaf9d6eecab_importance-of-editing-p-1600.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <h2 class="fw-bold mt-2">Team Redaksi</h2>
            <p>Kami didukung oleh tim handal dan profesional</p>
        </div>
    </header>

    <section class="container-xl my-5">
        <div class="row gx-5">
            <div class="col-lg-9">
                <div class="row justify-content-center g-4">
                    @forelse ($team as $val)
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card h-100 shadow-sm border-0 text-center">
                                <img src="{{ $val->image ? asset('storage/' . $val->image) : 'https://www.pngitem.com/pimgs/m/581-5813504_avatar-dummy-png-transparent-png.png' }}"
                                    class="card-img-top mx-auto mt-3 rounded-circle" alt="John Doe"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $val->name }}</h5>
                                    <p class="card-text text-muted">{{ $val->email }}</p>
                                    <hr>
                                    <div class="mt-3">
                                        <a target="_blank"
                                            href="https://mail.google.com/mail/u/0/?view=cm&tf=1&fs=1&to={{ $val->email }}"
                                            class="btn btn-primary rounded-pill me-2">Email</a>
                                        <a target="_blank"
                                            href="https://api.whatsapp.com/send/?phone=%2B62{{ $val->phone }}"
                                            class="btn btn-outline-success rounded-pill">Phone</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                Belum ada Team.
                            </div>
                        </div>
                    @endforelse
                </div>
                <br>
                <div class="row">
                    <div class="d-flex justify-content-center">
                        {{ $team->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
