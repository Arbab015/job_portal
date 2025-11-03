@extends('frontend.layouts.master')
@section('content')
<div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif
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
                            <h1 class="h1 text-success"><b>Find your dream job today</b></h1>
                            <p>
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
                            <h1 class="h1 text-success"><b>Your career starts here</b></h1>
                            <p>
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
                            <h1 class="h1 text-success"><b>Empowering careers, building futures</b></h1>
                            <p>
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

<!-- Apply Model -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="{{ route('job.apply')}}" enctype="multipart/form-data" class="needs-validation" novalidate id="job_apply-form">
                @csrf
                <input type="hidden" name="job_id" id="job_id">
                <div class="modal-header">
                    <h5 class="modal-title " id="myModalLabel">Job Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="name" class="col fw-bolder required">Name</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required placeholder="Enter your name">
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                        </div>
                        <div class="form-group col-6 py-2">
                            <label for="email" class="col fw-bolder required">Email </label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" required placeholder="Enter your email">
                                <div class="invalid-feedback">Please enter your email. </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="mobile_no" class="col fw-bolder required">Mobile Number</label>
                            <div class="col-sm-10">
                                <input type="text" name="mobile_no" class="form-control" required placeholder="Enter your Mobile number">
                                <div class="invalid-feedback">Please enter your Mobile number.</div>
                            </div>
                        </div>
                        <div class="form-group  col-6 py-2">
                            <label for="experience" class="col fw-bolder required">Total Experience</label>
                            <div class="col-sm-10">
                                <input type="text" name="experience" class="form-control" required placeholder="Experience">
                                <div class="invalid-feedback">Please enter your experience.</div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="skills" class="col fw-bolder required ">Skills</label>
                            <div class="col-sm-10">
                                <input type="text" id="skill_input" class="form-control" placeholder="Add your skill">
                                <div class="invalid-feedback">Please add at least one skill.</div>
                                <div class="badges-container" id="badgesContainer">
                                </div>
                                <input type="hidden" name="skills" id="skills_hidden">

                            </div>

                        </div>

                        <div class="form-group  col-6 py-2">
                            <label for="file" class="col fw-bolder required">Resume</label>
                            <div class="col-sm-10">
                                <input type="file" name="file" class="form-control" required>
                                <div class="invalid-feedback">Please add your CV file.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group py-2">
                        <label for="notes" class="col fw-bolder ">Note:</label>
                        <div class="col-sm-11">
                            <textarea id="note" class="form-control" name="notes" rows="2" cols="40" placeholder="Write something more about yourself."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Apply</button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
<!-- End Categories of The Month -->

<!-- Start Featured Product -->
<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-12 m-auto">
                <div class="header ">
                    <span class="h1"><b>Featured Jobs</b></span>
                    <span class="float-end link-success cursor-pointer"> <a class="link-success text-decoration-none" href="{{ route('jobs.viewall') }}">View all <i class="fa-solid fa-arrow-right"></i> </a></span>
                </div>
                <p>
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
                        <h5 class="text-center mt-3 mb-3">{{ $job->title }}</h5>
                        <div class="description-container">
                            <p class="text-center description-text mt-3 mb-3">{{ $job->description }}</p>
                        </div>
                        <p class="text-center"><a onclick="openModel('{{ $job->id }}')" class="btn btn-success">Apply now</a></p>
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
    function openModel(job_id) {
        document.getElementById('job_id').value = job_id;
        const modal = new bootstrap.Modal(document.getElementById('myModal'));
        modal.show();
    }

    const skillInput = document.getElementById('skill_input');
    const badgesContainer = document.getElementById('badgesContainer');
    const hiddenInput = document.getElementById('skills_hidden');
    let skillsArray = [];

    skillInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            const skillValue = skillInput.value.trim();
            if (skillValue && !skillsArray.includes(skillValue)) {
                addSkillBadge(skillValue);
                skillsArray.push(skillValue);
                updateHiddenInput();
                skillInput.value = '';
            }
        }
    });

    function addSkillBadge(skill) {
        const badge = document.createElement('span');
        badge.classList.add('badge', 'bg-primary', 'me-2', 'mb-2');
        badge.textContent = skill + " ";

        const closeButton = document.createElement('span');
        closeButton.textContent = " ×";
        closeButton.style.cursor = 'pointer';
        closeButton.onclick = function() {
            badgesContainer.removeChild(badge);
            skillsArray = skillsArray.filter(s => s !== skill);
            updateHiddenInput();
        };

        badge.appendChild(closeButton);
        badgesContainer.appendChild(badge);
    }

    function updateHiddenInput() {
        hiddenInput.value = JSON.stringify(skillsArray);
    }

    const form = document.getElementById('job_apply-form');
    form.addEventListener('submit', function(e) {
        updateHiddenInput();
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
</script>
@endpush
@push('style')
<style>
    .description-container {
        position: relative;
        overflow: hidden;
    }

    .required::after {
        content: " *";
        color: red;
    }

    .description-text {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-height: 3em;
        line-height: 1.5em;
        transition: max-height 0.3s ease-in-out;
    }

    .description-container:hover .description-text {
        -webkit-line-clamp: unset;
        max-height: fit-content;
        overflow: visible;
    }


    #skill_input {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    .badges-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        padding: 10px;
        min-height: 50px;
    }

    .badge {
        background-color: #007bff;
        color: white;
        padding: 5px 10px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        font-size: 0.9em;
    }

    .badge-close {
        margin-left: 5px;
        cursor: pointer;
        font-weight: bold;
    }
</style>
@endpush