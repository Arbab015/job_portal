@extends('layouts.master')

@section('content')
<div class="designation_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="title">Jobs</h2>


    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card ">
        <div class="card-header">Add Jobs</div>
        <form method="Post" class="py-3 needs-validation" id="jobs_form">
            @csrf
            <div class="form-group row py-2">
                <label for="title" class="col fw-bolder ">Job Title:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" required name="title" id="staticEmail"
                        placeholder="Enter a new Job Title ">
                    <div class="invalid-feedback">Please enter a Job Title.</div>
                </div>
            </div>
            <div class="form-group row py-2">
                <label for="description" class="col  fw-bolder ">Description: </label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="exampleFormControlTextarea1" required name="description" rows="3"
                        placeholder="Enter Job Description"></textarea>
                    <div class="invalid-feedback">Please enter a Job Description.</div>
                </div>
            </div>

            <div class="form-group row py-2">
                <label for="Job-Type" class="col fw-bolder ">Job Type: </label>
                <div class="col-sm-10">
                    <select class="form-select" required aria-label="Default select example">
                        <option value="" selected>Choose any Job Type</option>
                        @foreach ($jobtypes as $id => $type)
                        <option value="{{ $id }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select job type.</div>
                </div>
            </div>

            <div class="form-group row py-2">
                <label for="Job-Type" class="col fw-bolder ">Designation: </label>
                <div class="col-sm-10">
                    <select class="form-select" required aria-label="Default select example">
                        <option value="" selected>Choose any Designation</option>
                        < @foreach ($designations as $id => $type)
                        <option value="{{ $id }}">{{ $type }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Please select Designation.</div>
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
const form = $('#jobs_form');
//  form validation check
form.on('submit', function(e) {
    if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
    }
    $(this).addClass('was-validated');
});
</script>

@endpush