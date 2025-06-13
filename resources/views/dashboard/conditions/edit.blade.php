@extends('dashboard.layouts.main')

@section('title','Conditions')

@section('page-imports')
    @include('dashboard.includes.components.choices_css')
@endsection

@section('page-title', 'Conditions')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.conditions.index') }}">Conditions</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ $condition->name }}
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.conditions.update', $condition) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $condition->name }}"/>

                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="si_unit">SI Unit</label>
                        <input type="text" name="si_unit" id="si_unit" class="form-control @error('si_unit') is-invalid @enderror" value="{{ $condition->si_unit }}"/>

                        @error('si_unit')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
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