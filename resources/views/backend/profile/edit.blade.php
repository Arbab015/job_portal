@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="title">User / Profile</h2>
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
        <div class="card-header">Edit User</div>
        <form method="Post" action="{{ route('profile.update', $user->id) }}" class="py-3 needs-validation" enctype="multipart/form-data" novalidate id="users_form">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group  col-6 py-2">
                    <label for="name" class="col fw-bolder ">Username:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" required name="name" id="name" value="{{ old('name', $user->name) }}">
                        <div class="invalid-feedback">Please enter a user name.</div>
                    </div>
                </div>
                <div class="form-group  col-6 py-2">
                    <label for="email" class="col fw-bolder ">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" required name="email" id="name" value="{{ old('email', $user->email) }}">
                        <div class="invalid-feedback">Please enter a email.</div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group  col-6 py-2">
                    <label for="password" class="col fw-bolder ">Password: (optional)</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control"name="password" id="name"
                            placeholder="Your Password">
                        <div class="invalid-feedback">Please enter a password.</div>
                    </div>
                </div>

                <div class="form-group  col-6 py-2">
                    <label for="email" class="col fw-bolder ">Confirm Password: (optional)</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control"  name="password_confirmation" id="name"
                            placeholder="Confirm your password">
                        <div class="invalid-feedback">Please enter a email.</div>
                    </div>
                </div>
            </div>

            <div class="form-group  col-6 py-2">
                <label for="profile_picture" class="col fw-bolder ">Profile Picture:</label>
                <div class="col-sm-10">
                    <input type="file" name="profile_picture" id="profile_picture">
                </div>
            </div>

            <div class="form-group py-3">
                <button type="submit" class="btn btn-primary">Update Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')

<script>
    const form = $('#users_form');
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