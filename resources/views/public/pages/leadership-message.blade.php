@extends('layouts.public')

@section('meta_title', $page->meta_title ?: 'Leadership Message | F.S. Education Network')
@section('meta_description', $page->meta_description ?: 'A message from the leadership of F.S. Education on our ongoing commitment to youth empowerment and market-ready skills in Karachi.')

@section('meta_tags')
    <x-meta-tags
        :title="$page->meta_title ?: $page->title"
        :description="$page->meta_description"
    />
@endsection

@section('content')
<!-- Header -->
<div class="bg-fs-navy text-white py-5">
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2 small text-white-50">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/about') }}" class="text-white-50 text-decoration-none">About</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Leadership Message</li>
            </ol>
        </nav>
        <h1 class="display-5 fw-bold mb-2">{{ $page->title }}</h1>
        <p class="lead text-white-50 mb-0">Committed to empowering youth through industry-aligned vocational education</p>
    </div>
</div>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="page-content bg-white p-4 p-md-5 rounded-4 shadow-sm border">
                <div class="d-flex align-items-center gap-3 pb-4 mb-4 border-bottom">
                    <div class="rounded-circle bg-fs-navy text-white d-flex align-items-center justify-content-center fw-bold fs-3" style="width: 70px; height: 70px;">
                        FS
                    </div>
                    <div>
                        <h4 class="fw-bold text-dark mb-1">Executive Leadership</h4>
                        <span class="text-muted small">Managing Directorate, {{ setting('company_name', 'F.S. Education') }}</span>
                    </div>
                </div>

                {!! $page->body !!}
            </div>
        </div>
    </div>
</div>
@endsection

