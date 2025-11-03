@extends('frontend.layouts.master')
@section('content')
<section class="bg-light">
    <div class="container py-5">
        <div class="py-3">
            <div class="col-lg-12">
                <div>
                    <h1 class="h1 "><b>Jobs</b></h1>
                </div>
                <div class="row pt-2">
                    <div class="col-lg-12">
                        <form class="form-inline">
                            <div class="row">
                                <div class="form-group col-6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                                        <button class="btn btn-secondary" type="button">Search</button>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <select class="jobsearch form-select" aria-label="Default select example" name="job_type_id">
                                        <option value="" selected>Select JobType Category</option>
                                        @foreach ($jobtypes as $id => $type)
                                        <option value="{{ $id }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select class="jobsearch form-select" aria-label="Default select example" name="designation_id">
                                        <option value="" selected>Select Designation Category</option>
                                        < @foreach ($designations as $id=> $type)
                                            <option value="{{ $id }}">{{ $type }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                         <div class="col-lg-12 p-5">
                              <div class="searchicon text-center">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <p>Search Job by title, jobtypes and designation</p>
                              </div>

                         </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
    @push('style')
    <style>
        .jobsearch {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: none;
            border: 1px solid #ccc;
            padding: 8px;
        }
    </style>

    @endpush