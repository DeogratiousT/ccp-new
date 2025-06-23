@extends('dashboard.layouts.main')

@section('title','Sections')

@section('page-imports')
    @include('dashboard.includes.components.choices_css')
@endsection

@section('page-title', 'Sections')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.sections.index') }}">Sections</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ $section->name }}
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.sections.update', $section) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $section->name }}"/>

                        @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="rabbitmq_exchange">RabbitMQ Exchange</label>
                        <input type="text" name="rabbitmq_exchange" id="rabbitmq_exchange" class="form-control @error('rabbitmq_exchange') is-invalid @enderror" value="{{ $section->rabbitmq_exchange }}"/>

                        @error('rabbitmq_exchange')
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