@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="title">Jobs</h4>
        @can('add_job')
        <a href="{{ route('jobs.create')}}" class="btn btn-primary" id="addBtn" type="button">Add</a>
        @endcan
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
        <div class="card-header">Jobs list</div>
        <div class="card-body">
            <table class="table table-bordered " id="jobs-table">
                <button class="btn btn-danger" id="bulk_delete_btn" type="button">Bulk Delete</button>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all" title="select all"></th>
                        <th>Title</th>
                        <th>Job Type</th>
                        <th>Designation</th>
                        @if($show_actions)
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#jobs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('jobs.index') }}",
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title',
                },
                {
                    data: 'job_type',
                    name: 'job_type_id'
                },
                {
                    data: 'designation',
                    name: 'designation_id'
                },
                @if($show_actions) {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
                @endif
            ]
        });
    });
</script>
@endpush

@push('styles')
<style>
    table.dataTable td:nth-child(2),
    table.dataTable td:nth-child(3),
    table.dataTable td:nth-child(4) table.dataTable td:nth-child(5) {
        word-break: break-all;
        white-space: pre-line;
    }
</style>
@endpush