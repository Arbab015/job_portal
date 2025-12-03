@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="title">Roles</h4>

        <a href="{{ route('role.create')}}" class="btn btn-primary" id="addBtn" type="button">Create</a>

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
            <table class="table table-bordered " id="role_table">
                <button class="btn btn-danger" id="bulk_delete_btn" type="button">Bulk Delete</button>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all" title="select all"></th>
                        <th>Name</th>
                        <th>Permissions</th>
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
        $('#role_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('roles.index') }}",
            "createdRow": function(row, data) {
                if (data.name === "Super Admin") {
                    $(row).hide();
                }
            },
            columns: [{
                    data: 'checkbox',
                    name: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'permissions',
                    name: 'permissions'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ]
        });

    });

</script>
@endpush

@push('styles')
<style>
    table.dataTable td:nth-child(3) {
        word-break: break-all;
        white-space: pre-line;
    }
</style>

@endpush