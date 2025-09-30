@extends('layouts.frontend.master')

@section('informationActive')
    active
@endsection

@section('metaDesc')
    {{ $information->meta_desc }}
@endsection

@section('content')
    <section class="container-xl my-5">
        <div class="row gx-4">
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-body p-4 p-md-5">
                        <h1 class="card-title mb-3" style="font-size: 2rem; font-weight: 700;">{{ $information->title }}</h1>
                        <div class="text-muted mb-4 d-flex flex-wrap align-items-center small">
                            <span class="me-3">
                                <i class="fas fa-calendar-alt me-1"></i> Diperbaharui :
                                {{ $information->updated_at->format('d M Y') }}
                            </span>
                            <span>
                                <i class="fas fa-info-circle me-1"></i> Status:
                                @if ($information->status)
                                    <span class="badge bg-primary">Published</span>
                                @else
                                    <span class="badge bg-danger">Draft</span>
                                @endif
                            </span>
                        </div>

                        <hr class="my-3">

                        <div class="note-editable mt-4" style="font-size: 1rem; line-height: 1.5;">
                            {!! $information->content !!}
                        </div>

                        <hr class="my-3">

                        <div class="text-end">
                            <a href="{{ route('home.information.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- sidebar -->
            @include('home.information.sidebar')
        </div>
    </section>
@endsection
