@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="title">Jobs</h4>
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif

    <div class="card ">
        <div class="card-header">Add Job</div>
        <form method="Post" action="{{ route('jobs.store') }}" class="py-3 needs-validation" novalidate id="jobs_form">
            @csrf
            <div class="row">
                <div class="form-group  col-6 py-2">
                    <label for="title" class="col fw-bolder ">Job Title:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required name="title" id="title"
                            placeholder="Enter a new Job Title " onkeyup="generateSlug()">
                        <div class="invalid-feedback">Please enter a Job Title.</div>
                    </div>
                </div>
                <div class="form-group  col-6 py-2">
                    <label for="title" class="col fw-bolder">Slug:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="slug" id="slug" readonly
                            placeholder="Slug">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-6 py-2">
                    <label for="Job-Type" class="col fw-bolder ">Job Type: </label>
                    <div class="col-sm-10">
                        <select class="form-select" required aria-label="Default select example" name="job_type_id">
                            <option value="" selected>Choose any Job Type</option>
                            @foreach ($jobtypes as $id => $type)
                            <option value="{{ $id }}">{{ $type }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Please select job type.</div>
                    </div>
                </div>
                <div class="form-group col-6 py-2">
                    <label for="Job-Type" class="col fw-bolder ">Designation: </label>
                    <div class="col-sm-10">
                        <select class="form-select" required aria-label="Default select example" name="designation_id">
                            <option value="" selected>Choose any Designation</option>
                            <@foreach ($designations as $id=> $type)
                                <option value="{{ $id }}">{{ $type }}</option>
                                @endforeach
                        </select>
                        <div class="invalid-feedback">Please select Designation.</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6 py-2">
                    <label for="description" class="col  fw-bolder ">Location: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required name="address" placeholder="Enter location">
                        <div class="invalid-feedback">Please enter location.</div>
                    </div>
                </div>
                <div class="form-group col-6 py-2">
                    <label for="description" class="col  fw-bolder ">Due Date: </label>
                    <div class="col-sm-10">
                        <input type="date" id="due_date" class="form-control" required name="due_date" id="due_date">
                        <div class="invalid-feedback">Please select due date.</div>
                    </div>
                </div>

            </div>
            <div class="form-group  py-2">
                <label for="description" class="col  fw-bolder ">Description: </label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="job_description" required name="description"
                        placeholder="Enter your Job description"></textarea>
                    <div class="invalid-feedback">Please enter a Job Description.</div>
                </div>
            </div>
            <div class="form-group py-3">
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    ClassicEditor.create(document.querySelector('#job_description'), {
        ckfinder: {
            uploadUrl: "{{ route('jobs.store') }}?_token={{ csrf_token() }}"
        }
    });

    const form = $('#jobs_form');
    //  form validation check
    form.on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });

    function generateSlug() {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const title = titleInput.value;
        const slug = title
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w-]+/g, '')
            .replace(/--+/g, '-')
            .trim();

        slugInput.value = slug;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const year = today.getFullYear();
        const month = (today.getMonth() + 1).toString().padStart(2, '0'); // Month is 0-indexed
        const day = today.getDate().toString().padStart(2, '0');

        const minDate = `${year}-${month}-${day}`;
        document.getElementById('due_date').setAttribute('min', minDate);
    });
</script>

@endpush