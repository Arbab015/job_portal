@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="title">Role / Create</h4>


    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif

    <div class="card ">
        <div class="card-header">Create Role</div>
        <form method="Post" action="{{ route('role.store') }} " class="py-3 needs-validation" novalidate id="roles_form">
            @csrf
            <div class="form-group  col-6 py-2">
                <label for="name" class="col fw-bolder ">Role Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" required name="name" id="name"
                        placeholder="Enter a new role">
                    <div class="invalid-feedback">Please enter a role.</div>
                </div>
            </div>

            <div class="py-2">
                <p class="fw-bolder">Permissions:</p>
                @if($permissions->isNotEmpty())
                @foreach ($permissions->chunk(4) as $chunk)
                <div class="row">
                    @foreach ($chunk as $permission)
                    <div class="col-md-3">
                        <div class="form-check my-1">
                            @if($permission->name === 'dashboard')
                            <input type="hidden" name="permission[]" value="dashboard">
                            @endif
                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="permission[]"
                                id="permission-{{ $permission->id }}"
                                value="{{ $permission->name }} "
                                {{ $permission->name ==="dashboard" ? 'checked disabled': '' }}>
                            <label class="form-check-label" for="permission-{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
                @endif
            </div>

            <div class="form-group py-3">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')

<script>
    const form = $('#roles_form');
    //  form validation check
    form.on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });
</script>

@endpush