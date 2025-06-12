@extends('dashboard.layouts.full')

@section('title', 'LOGIN')

@section('page-title', 'Log In.')

@section('content')
    <form method="post" action="{{ route('login') }}">
        @csrf

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email"/>
            <div class="form-control-icon">
                <i class="bi bi-person"></i>
            </div>
        </div>

        <div class="form-group position-relative has-icon-left mb-4">
            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password"/>
            <div class="form-control-icon">
                <i class="bi bi-shield-lock"></i>
            </div>
        </div>

        <div class="form-check form-check-lg d-flex align-items-end">
            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault"/>
            <label class="form-check-label text-gray-600" for="flexCheckDefault">Keep me logged in</label>
        </div>

        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-4">Log in</button>
    </form>

    <div class="text-center mt-5 text-lg fs-4">
        <p class="text-gray-600 mb-0">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-bold">Sign up</a>
        </p>
        <p>
            <a class="font-bold fs-5" href="{{ route('password.request') }}">Forgot password?</a>
        </p>
    </div>
@endsection