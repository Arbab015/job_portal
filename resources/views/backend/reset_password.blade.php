@extends('layouts.master', ['hideComponent' => TRUE] )
@section('content')
<div class="container-new">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 colforget-sm-8 colforget-md-6 colforget-lg-5 colforget-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center header-center mb">
                    <h3 class="text-primary">Reset Password</h3>
                </div>
                <div class="forget_msg">

                </div>
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="floatingInput" value="{{ old('email', $request->email) }}" readonly>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">New Password</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password_confirmation" class="form-control" id="floating_Password"
                            placeholder="Password">
                        <label for="floatingPassword">Confirm Password</label>
                    </div>

                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection