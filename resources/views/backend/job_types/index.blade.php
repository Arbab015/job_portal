@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="title">Job Types</h2>
        @can('add_jobtype')
        <button type="button" class="btn btn-primary" id="addBtn">Add</button>
        @endcan
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">Job Types List</div>
        <div class="card-body">
            <table class="table table-bordered" id="job-types-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Type</th>
                        @if($show_actions)
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" class="needs-validation" novalidate id="job_types-form">
                @csrf
                <div id="methodField"></div>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">

                        <input type="text" name="title" class="form-control" required placeholder="Enter a new Job Type">
                        <div class="invalid-feedback">Please enter a job title.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button class="btn-soft" type="submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(function() {
        const modal = new bootstrap.Modal(document.getElementById('myModal'));
        const form = $('#job_types-form');
        const methodField = $('#methodField');
        const nameInput = $('input[name="title"]');

        $('#job-types-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('job_types.index') }}",
            columns: [{
                    data: 'serial_no',
                    name: 'serial_no',
                    className: 'dt-left',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                @if($show_actions) 
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
                @endif
            ]
        });

        // add button functionality
        $('#addBtn').on('click', function() {
            methodField.html('');
            nameInput.val('');
            $('#myModalLabel').text('Add Job Type');
            modal.show();
        });

        // edit button functionality
        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');

            form.attr('action', '/job_types/' + id);
            methodField.html('<input type="hidden" name="_method" value="PUT">');
            nameInput.val(title);
            $('#myModalLabel').text('Edit Job Type');
            modal.show();

        });


        //  form validation check
        form.on('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            $(this).addClass('was-validated');
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
</script>
@endpush

@push('styles')
<style>

table.dataTable td:nth-child(2)
{
  word-break: break-all;
  white-space: pre-line;
}
</style>

@endpush