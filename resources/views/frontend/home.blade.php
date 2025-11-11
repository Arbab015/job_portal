@extends('frontend.layouts.master')
@section('content')
<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
        <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset('img/meeting_img1.jpg') }} " alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left align-self-center">
                            <h2 class="h1 text-success Baloo_2"><b>Find your dream job today</b></h1>
                                <p class="Arima"> 
                                    Discover thousands of career opportunities tailored to your skills and passion.
                                    Our platform makes it easy to explore top companies and apply in just a few clicks.
                                    Take control of your future — your dream job is only a search away.
                                </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset('img/meeting_img2.jpg') }}" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1 text-success Baloo_2"><b>Your career starts here</b></h1>
                            <p class="Arima"> 
                                Begin your professional journey with access to the latest job openings from trusted companies.
                                Find roles that match your interests, experience, and expertise.
                                Your future career path starts right here — take the first step today.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-item">
            <div class="container">
                <div class="row p-5">
                    <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                        <img class="img-fluid" src="{{ asset('img/meeting_img3.jpg') }}" alt="">
                    </div>
                    <div class="col-lg-6 mb-0 d-flex align-items-center">
                        <div class="text-align-left">
                            <h1 class="h1 text-success Baloo_2"><b>Empowering careers, building futures</b></h1>
                            <p class="Arima">
                                We believe in helping people achieve their career goals with confidence.
                                Explore a wide range of jobs and apply to roles that inspire growth.
                                Together, we build a future where your talent meets the right opportunity.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
        <i class="fas fa-chevron-left"></i>
    </a>
    <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
        <i class="fas fa-chevron-right"></i>
    </a>
</div>
<!-- End Banner Hero -->
</section>
<!-- End Categories of The Month -->

<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-12 m-auto">
                <div class="header ">
                    <span class="featured_job text-success"><b>Featured Jobs</b></span>
                    <span class="float-end link-success cursor-pointer"> <a class="link-success text-decoration-none" href="{{ route('jobs.all') }}">View all <i class="fa-solid fa-arrow-right"></i> </a></span>
                </div>
                <p class="Arima">
                    Our <strong>Featured Jobs</strong> section highlights top career opportunities from trusted employers across different industries.
                    These listings are carefully selected to help you find the most relevant positions that match your skills, experience, and goals.
                    Browse through the featured openings, explore job details, and apply directly with just one click.
                    Start your journey toward a better career today — your next big opportunity could be right here!
                </p>

            </div>
        </div>
        <div class="row">
            @foreach($latest_jobs as $job)
            <div class="col-12 col-md-4 mb-4">
                <div class="card h-100">
                    <a href="{{ route('jobs.detail', $job->slug) }}">
                        <img src="{{asset('img/job-search.webp')}}" class="card-img-top" alt="...">
                    </a>
                    <div class="card-body">
                        <h5 class="text-center mt-3 mb-3 text-success">{{ ucfirst($job->title) }}</h5>
                        <p class="text-center mt-2 mb-1 Poppins"><b>Designation: </b>{{ ucfirst($job->designation->name) }}</p>
                        <p class="text-center mt-3 mb-1 Poppins"><b>Type: </b>{{ ucfirst($job->jobType->title) }}</p>
                        <p class="text-center mt-3 "><a onclick="openApplyModel('{{ $job->id }}')" class="btn btn-success">Apply now</a></p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- End Featured Product -->
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
        @endif

        @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
        @endif

        @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
        @endif
    });
</script>
@endpush