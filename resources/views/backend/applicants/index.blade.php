@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="title">Applicants</h2>

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
        <div class="card-header">Applicants list</div>
        <div class="card-body">
            <table class="table table-bordered " id="applicants-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Job Title</th>
                        <th>Skills</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Actions</th>
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
        $('#applicants-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('applicants.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'mobile_no',
                    name: 'mobile_no'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'job',
                    name: 'job_id'
                },
                {
                    data: 'skills',
                    name: 'skills'
                },

                {
                    data: 'file',
                    name: 'file'
                },
                {
                    data: 'status',
                    name: 'status',
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
@endpush

@push('styles')
<style>
    table.dataTable td:nth-child(2),
    table.dataTable td:nth-child(3),
    table.dataTable td:nth-child(4),
    table.dataTable td:nth-child(5),
    table.dataTable td:nth-child(6) {
        word-break: break-all;
        white-space: pre-line;
    }
</style>
@endpush