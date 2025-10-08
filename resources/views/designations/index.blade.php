@extends('layouts.master')
@section('content')
<div class="designation_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="mb-0">Designations</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
            Add
        </button>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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

@include('components.model') {{-- your modal markup --}}
@endsection

@push('scripts')

@if ($errors->any())
<script>
  const myModal = new bootstrap.Modal(document.getElementById('myModal'));
  myModal.show();
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#designations-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("designations.index") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
});


    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
</script>

@endpush
