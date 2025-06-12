@extends('dashboard.layouts.full')

@section('title', 'FORGOT PASSWORD')

@section('page-title', 'Forgot Password')

@section('page-description')
    Forgot your Password? No problem. <br> 
    Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
@endsection

@section('content')
    <form method="post" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" class="form-control form-control-xl" placeholder="Email"/>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>

        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4">Email Password Reset Link</button>
    </form>

    <div class="text-center mt-5 text-lg fs-4">
        <p>
            <a class="font-bold" href="{{ route('login') }}">Back to Log In</a>
        </p>
    </div>
@endsection