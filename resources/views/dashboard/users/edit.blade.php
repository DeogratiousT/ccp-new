@extends('dashboard.layouts.main')

@section('title','Users')

@section('page-imports')
    @include('dashboard.includes.components.choices_css')
@endsection

@section('page-title', 'Users')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.users.index') }}">Users</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ $user->name }}
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="name">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}"/>

                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $user->email }}"/>

                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="roles">Roles</label>
                        <select name="roles[]" id="roles" class="choices form-select multiple-remove @error('roles') is-invalid @enderror" multiple>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>

                        @error('roles')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="password">
                            Password
                            <small class="text-muted">Atleast 8 Mixed Characters</small>
                        </label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"/>

                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
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