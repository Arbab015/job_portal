@extends('layouts.master')

@section('content')
<div class="designation_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="title">Jobs</h2>
        <button type="submit" onclick="window.location='{{ route('jobs.create') }} '"  class="btn btn-primary" id="addBtn">Add</button>


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

    <div class="card">
        <div class="card-header">Jobs</div>
        <div class="card-body">
            <table class="table table-bordered" id="job-types-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>


@endsection