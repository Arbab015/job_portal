@extends('frontend.layouts.master')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0 p-4">
                <h2 class="text-success mb-3">{{ $job->title }}</h2>
               
                <p class="text-muted mb-2">
                    <strong>Job Type:</strong> {{ $job->jobType->title }}
                </p>
                <p class="text-muted mb-2">
                    <strong>Designation:</strong> {{ $job->designation->name }}
                </p>
                <p class="text-muted mb-2">
                    <strong>Posted On:</strong> {{ $job->created_at->format('M d, Y') }}
                </p>
                <hr>
                <h5 class="fw-bold mt-3">Job Description:</h5>
                <p>{{ $job->description }}</p>

                <div class="mt-4">
                    <a onclick="openModel()" class="btn btn-success">Apply Now</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- model -->

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="{{ route('job.apply')}}" class="needs-validation" novalidate id="job_apply-form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title " id="myModalLabel">Apply for a job</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="title" class="col fw-bolder ">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" required placeholder="Enter your name">
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>
                        </div>
                        <div class="form-group col-6 py-2">
                            <label for="Job-Type" class="col fw-bolder ">Email: </label>
                            <div class="col-sm-10">
                                <input type="text" name="email" class="form-control" required placeholder="Enter your email">
                                <div class="invalid-feedback">Please enter your email. </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group  col-6 py-2">
                            <label for="title" class="col fw-bolder ">Phone Number:</label>
                            <div class="col-sm-10">
                                <input type="text" name="phone_no" class="form-control" required placeholder="Enter your phone number">
                                <div class="invalid-feedback">Please enter your phone number.</div>
                            </div>
                        </div>
                        <div class="form-group  col-6 py-2">
                            <label for="title" class="col fw-bolder ">Total Experience:</label>
                            <div class="col-sm-10">
                                <input type="text" name="experience" class="form-control" required placeholder="Experience like 1-year etc ">
                                <div class="invalid-feedback">Please enter your experience.</div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group  py-2">
                        <label for="title" class="col fw-bolder ">Note:</label>
                        <div class="col-sm-11">
                            <textarea id="note" class="form-control" name="note" rows="2" cols="40" placeholder="Write something more about yourself like qualification etc."></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-success" type="submit">Apply For Job</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModel() {
        const modal = new bootstrap.Modal(document.getElementById('myModal'));
        modal.show();
    }

    const form = document.getElementById('job_apply-form');
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
</script>
@endpush