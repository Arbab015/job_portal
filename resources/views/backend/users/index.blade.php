@extends('backend.layouts.master')
@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="title">Users</h2>
        </div>
        <div>
            <span id="import_progress"></span>
            <button type="button" class="btn btn-primary" id="import_btn">Import</button>
            <a href="{{ route('users.create') }}" class="btn btn-primary" id="addBtn" type="button">Create</a>
        </div>

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
        <div class="card-header">Users list</div>
        <div class="card-body">
            <table class="table table-bordered " id="users_table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('users.import') }}" enctype="multipart/form-data" class="needs-validation" novalidate id="import_file_form">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Import File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Upload CSV File</label>
                            <input class="form-control" type="file" name="csv_file" required id="csvFile" accept=".csv">
                            <div class="invalid-feedback">Please choose a CSV file.</div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn-soft" id="submitBtn" type="button">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#users_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            "createdRow": function(row, data) {
                if (data.roles === "Super Admin") {
                    $(row).hide();
                }
            },
            columns: [{
                    data: 'serial_no',
                    name: 'serial_no',
                    className: 'dt-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles'
                },
                {
                    data: 'actions',
                    name: 'actions'
                }
            ]
        });

    });



    // sweetalert on delete
    function confirmDelete(event) {
        event.preventDefault();
        var form = event.target.closest('form');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    $('#import_btn').on('click', function() {
        modal.show();
    });


    // model form validation
    const form = $('#import_file_form');
    const modal = new bootstrap.Modal(document.getElementById('myModal'));

    form.on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });



    // to show progress on import csv file
    function showProgress() {
        $.ajax({
            url: 'get_progress',
            method: 'GET',
            success: function(response) {
                if (response.percentage == undefined) {
                    $('#import_progress').hide();
                } else {
                    $('#import_progress')
                        .text('Import Progress: ' + response.percentage + '%')
                        .show();
                }
            },
            error: function() {
                $('#import_progress').text('Error ');
            }
        });

    }
    setInterval(showProgress, 200);

    const myButton = document.getElementById('submitBtn');
    const progress = document.getElementById('import_progress');
    myButton.addEventListener('click', function(event) {
        form.submit();
        modal.hide();
        progress.context("Import start")
    });
</script>
@endpush

@push('styles')
<style>
    table.dataTable td:nth-child(2) {
        word-break: break-all;
        white-space: pre-line;
    }
</style>

@endpush