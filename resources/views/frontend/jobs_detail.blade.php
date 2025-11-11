@extends('frontend.layouts.master')
@section('content')

<div class="container py-5">
    <div class="col-lg-8 mx-auto">
        <div class="card shadow-sm border-0 p-4">
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
            @endif

            <h2 class="text-success mb-2">{{ ucfirst($job->title) }}</h2>
            <p class="text-muted mb-2 Poppins">
                {{ $job->address }} - {{ $period }} - {{ $no_of_applicants }} Applicants
            </p>
            <button class="text-muted mb-2 btn btn-light border border-dark rounded-pill Baloo_2" style="width: fit-content;"><i class="fa-solid fa-check"></i> {{ $job->jobType->title }}</button>
            <button class="text-muted mb-2 btn btn-light border border-dark rounded-pill Baloo_2" style="width: fit-content;"><i class="fa-solid fa-check"></i> {{ $job->designation->name }}</button>
            <div class="text-muted">
                <p onclick="openApplyModel('{{ $job->id }}')" class="btn btn-primary rounded-pill btn-sm Poppins">Apply Now</p>
            </div>
            <hr>
            <h5 class="fw-bold mt-3 Roboto">About the job</h5>
            <p>{!! $job->description !!}</p>
        </div>
    </div>
</div>
@endsection