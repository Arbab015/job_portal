@extends('layouts.master', ['hideComponent' => TRUE] )
@section('content')
<div class="container-new">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 colforget-sm-8 colforget-md-6 colforget-lg-5 colforget-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center justify-content-between mb">
                    <a href="" class="">
                        <h3 class="text-primary">DASHMIN</h3>
                    </a>
                    <h3>Forget Password</h3>
                </div>
                <div class="forget_msg">
                  <p> Please enter the email address you'd like to your password reset information sent to </p>
                </div>
                <form method="POST" action="{{ route('forgot_password.reset') }}">
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
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="floatingInput"
                            value="{{ old('email')}}">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Send Reset Link</button>

                    <a class="login-back" href="login"> Back to login</a>
                 
                </form>

            </div>
        </div>
    </div>
</div>
@endsection