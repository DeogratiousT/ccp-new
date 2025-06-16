@extends('dashboard.layouts.main')

@section('title','Processing Lines')

@section('page-imports')
    @include('dashboard.includes.components.choices_css')
@endsection

@section('page-title', 'Processing Lines')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.processinglines.index') }}">Processing Line</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ $processingLine->description}}
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.processinglines.update', ['processingline'=>$processingLine]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="section_id">Section</label>
                        <select name="section_id" id="section_id" class="form-control @error('section_id') is-invalid @enderror">
                            <option disabled selected>Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}" @if($processingLine->section_id == $section->id) selected @endif>{{ $section->name }}</option>
                            @endforeach
                        </select>

                        @error('section_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                 <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ $processingLine->description }}"/>

                        @error('description')
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