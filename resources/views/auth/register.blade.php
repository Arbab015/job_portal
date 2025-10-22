@extends('layouts.master', ['hideComponent' => TRUE] )
@section('content')
<div class="container-new">
    <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
            <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                <div class="d-flex align-items-center header-center mb-3">
                  
                    <h3 class="text-primary" >Sign up</h3>
                </div>

                <form method="post" action="{{ route('register.post') }}">
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
                        <input type="text" name="name" class="form-control" id="floatingText" value="{{ old('name') }}">
                        <label for="floatingText">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" name="email" class="form-control" id="floatingInput"
                            value="{{ old('email') }}">
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password" class="form-control" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating mb-4">
                        <input type="password" name="password_confirmation" class="form-control" id="floating_Password"
                            placeholder="Password">
                        <label for="floatingPassword">Confirm Password</label>
                    </div>
                 
                    <button type="submit" class="btn btn-primary py-3 w-100 mb-4">SIGN UP</button>
                    <p class="text-center mb-0">Already have an Account? <a href="{{ route('login') }} ">Login</a></p>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection