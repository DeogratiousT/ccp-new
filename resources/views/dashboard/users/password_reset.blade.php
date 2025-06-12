@extends('dashboard.layouts.main')

@section('title','Password Update')

@section('page-imports')
    @include('dashboard.includes.components.choices_css')
@endsection

@section('page-title', 'Password Update')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="#">{{ $user->name }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Password Update
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="text-info mb-4">You have to reset your password to proceed</h4>
            <form action="{{ route('dashboard.users.password.reset') }}" method="POST" id="update-user-password-form">
                @csrf

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="password">
                            Password
                            <small class="text-muted">Atleast 8 Mixed Characters</small>
                        </label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"/>

                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"/>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="submit" id="kt_projects_submit" class="btn btn-primary" onclick="formSubmit(this)">
                        <span class="indicator-label">Continue</span>
                        <span class="indicator-progress d-none">Please wait... 
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div> <!-- end card-body -->
    </div> <!-- end card -->
@endsection

@push('scripts')
    @include('dashboard.includes.components.choices_js')
@endpush