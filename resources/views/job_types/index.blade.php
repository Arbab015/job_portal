@extends('layouts.master')

@section('content')
<div class="designation_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="title">Job Types</h2>
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
        <div class="card-header">Job Types List</div>
        <div class="card-body">
            <table class="table table-bordered" id="job-types-table">
                <thead>
                    <tr>
                        <th>Job Type</th>
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
            <form method="POST" class="needs-validation" id="job-types-form">
                @csrf
                <div id="methodField"></div>

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tob Type</label>
                        <input type="text" name="title" class="form-control" required placeholder="Enter a new Job Type">
                        <div class="invalid-feedback">Please enter a Job Title.</div>
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
    const form = $('#job-types-form');
    const methodField = $('#methodField');
    const nameInput = $('input[name="title"]');

    $('#job-types-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('job_types.index') }}",
        columns: [{
                data: 'title',
                name: 'title'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false
            }
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
</script>
@endpush