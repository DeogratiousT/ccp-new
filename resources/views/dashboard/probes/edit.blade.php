@extends('dashboard.layouts.main')

@section('title','Probes')

@section('page-imports')
    @include('dashboard.includes.components.choices_css')
@endsection

@section('page-title', 'Probes')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.sections.index') }}">Sections</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.sections.probes.index', $section) }}">{{ $section->name }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            {{ $probe->uuid }}
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('dashboard.sections.probes.update', ['section'=>$section, 'probe'=>$probe]) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="section_id" value="{{ $section->id }}">

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="rabbitmq_queue">RabbitMQ Queue</label>
                        <input type="text" name="rabbitmq_queue" id="rabbitmq_queue" class="form-control @error('rabbitmq_queue') is-invalid @enderror" value="{{ $probe->rabbitmq_queue }}"/>

                        @error('rabbitmq_queue')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="condition_id">Condition</label>
                        <select name="condition_id" id="condition_id" class="form-control @error('condition_id') is-invalid @enderror">
                            <option disabled selected>Select Condition</option>
                            @foreach ($conditions as $condition)
                                <option value="{{ $condition->id }}" @if($probe->condition_id == $condition->id) selected @endif>{{ $condition->name }}</option>
                            @endforeach
                        </select>

                        @error('condition_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="min_threshold">Min Threshold</label>
                        <input type="text" name="min_threshold" id="min_threshold" class="form-control @error('min_threshold') is-invalid @enderror" value="{{ $probe->min_threshold }}"/>

                        @error('min_threshold')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label" for="max_threshold">Max Threshold</label>
                        <input type="text" name="max_threshold" id="max_threshold" class="form-control @error('max_threshold') is-invalid @enderror" value="{{ $probe->max_threshold }}"/>

                        @error('max_threshold')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                 <div class="row mb-4">
                    <div class="form-group col-12">
                        <label class="form-label" for="description">Description</label>
                        <input type="text" name="description" id="description" class="form-control @error('description') is-invalid @enderror" value="{{ $probe->description }}"/>

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