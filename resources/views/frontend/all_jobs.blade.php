@extends('frontend.layouts.master')
@section('content')

<section class="bg-light">
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif
    <div class="container py-5">
        <div class="">
            <div class="col-lg-12">
                <div>
                    <h2 class="text-success Roboto"><b>Jobs</b></h2>
                </div>
                <div class="row pt-2">
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <div class="row">
                                <div class="form-group col-6">
                                    <form>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search_term" name="search_term" placeholder="Search " aria-label="Search" aria-describedby="basic-addon1" value="{{ old('search_term', $search_term) }}">
                                            <button class="btn btn-secondary Baloo2" id="search_btn" type="submit">Search</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-3">
                                    <select class="jobsearch form-select" id="job_type" aria-label="Default select example" name="job_type">
                                        <option value="" selected>Select JobType Category</option>
                                        @foreach ($jobtypes as $id => $type)
                                        <option value="{{ $id}}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select class="jobsearch form-select" id="designation" aria-label="Default select example" name="designation">
                                        <option value="" selected>Select Designation Category</option>
                                        @foreach ($designations as $id=> $type)
                                        <option value="{{ $id }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="job_listing" class="row mt-5">
                            <!-- all jobs  -->
                        </div>

                        <!-- load more -->
                        <div id="load_more" class="col-lg-12 p-5 text-center ">
                            <button class="btn btn-secondary btn-sm " id="load_more_btn">
                                <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status" aria-hidden="true"></span>
                                <span class="button-text" id="button_text">Load More</span>
                            </button>
                        </div>
                        <!-- before_search -->
                        <div id="before_search" class="col-lg-12 p-5">
                            <div class="searchicon text-center mt-3">
                                <i class="fa-solid fa-magnifying-glass mb-3 " style="font-size: 70px"></i>
                                <p>Search Job by title, jobtype and designation </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection