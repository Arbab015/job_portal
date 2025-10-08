@extends('layouts.master')

@section('content')
<div class="designation_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0">Designations</h2>
        <button type="button" class="btn btn-primary" id="addBtn">Add</button>
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
        <div class="card-header">Designation List</div>
        <div class="card-body">
            <table class="table table-bordered" id="designations-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Designation Name</th>
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
            <form method="POST" class="needs-validation" novalidate id="designationForm">
                @csrf
                <div id="methodField"></div>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Add Designation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Designation Name</label>
                        <input type="text" name="name" class="form-control" required
                            placeholder="Enter designation name">
                        <div class="invalid-feedback">Please enter a designation name.</div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary " type="submit">Save changes</button>
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
                data: 'id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

    $('#addBtn').on('click', function() {
        form.attr('action', "{{ route('designations.store') }}");
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