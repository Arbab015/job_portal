@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="title">Designations</h4>
        @can('add_designation')
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
        <div class="card-header">Designation List</div>
        <div class="card-body">
            <table class="table table-bordered" id="designations-table">
                <button class="btn btn-danger" id="bulk_delete_btn" type="button">Bulk Delete</button>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all" title="select all"></th>
                        <th>Designation Name</th>
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
            <form method="POST" class="needs-validation" novalidate id="designationForm">
                @csrf
                <div id="methodField"></div>
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" required
                            placeholder="Enter a designation name">
                        <div class="invalid-feedback">Please enter a designation name.</div>
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
        const form = $('#designationForm');
        const methodField = $('#methodField');
        const nameInput = $('input[name="name"]');

        $('#designations-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('designations.index') }}",
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
                @if($show_actions) {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
                @endif
            ]
        });

        $('#addBtn').on('click', function() {
            methodField.html('');
            nameInput.val('');
            $('#myModalLabel').text('Add Designation');
            modal.show();
        });

        $(document).on('click', '.edit-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            form.attr('action', '/designations/' + id);
            methodField.html('<input type="hidden" name="_method" value="PUT">');
            nameInput.val(name);
            $('#myModalLabel').text('Edit Designation');
            modal.show();
        });

        form.on('submit', function(e) {
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            $(this).addClass('was-validated');
        });
    });
</script>
@endpush

@push('styles')
<style>
    table.dataTable td:nth-child(2),
    table.dataTable td:nth-child(3),
    table.dataTable td:nth-child(4) {
        word-break: break-all;
        white-space: pre-line;
    }
</style>
@endpush