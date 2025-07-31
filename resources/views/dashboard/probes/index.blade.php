@extends('dashboard.layouts.main')

@section('title','Probes')

@section('page-imports')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"/>
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
            Probes
        </li>
    </ol>
@endsection

@section('page-action')
    <a href="{{ route('dashboard.sections.probes.create', $section) }}" class="btn btn-primary m-4">
        <i class="bi bi-plus"></i> New Probe
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="probes-table">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th>#</th>
                            <th>Serial</th>
                            <th>Condition</th>
                            <th>Section</th>
                            <th>Min Threshold</th>
                            <th>Max Threshold</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($probes as $index => $probe)
                            <tr>
                                <td></td>
                                <td>{{ $probe->serial }}</td>
                                <td>{{ $probe->condition->name }}</td>
                                <td>{{ $probe->section->name }}</td>
                                <td>{{ $probe->min_threshold }}</td>
                                <td>{{ $probe->max_threshold }}</td>
                                <td>
                                    <button class="btn icon btn-light" data-bs-toggle="modal" data-bs-target="#show-probe-{{ $probe->id }}-modal">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>

                                    <a href="{{ route('dashboard.sections.probes.edit', ['section'=>$section, 'probe'=>$probe]) }}" class="btn icon btn-primary" data-bs-toggle="tooltip" title="Edit Section">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <button class="btn icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete-section-{{ $probe->id }}-modal">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-body -->
    </div> <!-- end card -->

    @foreach ($probes as $probe)
    <!--start:: Show Modal -->
        <div class="modal fade" tabindex="-1" id="show-probe-{{ $probe->id }}-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $probe->uuid }}</h4>

                        <!--begin::Close-->
                        <button class="btn icon btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body row">
                        <h4 class="mb-2">{{ $probe->serial }}</h4>
                        <p>{{ $probe->description }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Show Modal -->

        <!--start:: Delete Modal -->
        <div class="modal fade" tabindex="-1" id="delete-section-{{ $probe->id }}-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete {{ $probe->name }}</h4>

                        <!--begin::Close-->
                        <button class="btn icon btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body row">
                        <form action="{{ route('dashboard.sections.probes.destroy', ['section'=>$section, 'probe'=>$probe]) }}" method="POST" id="delete-section-{{ $probe->id }}-form">
                            @csrf
                            @method('DELETE')

                            <p>Are you sure that you want to delete this Probe?</p>

                            <button type="submit" class="btn btn-danger" onclick="formSubmit(this)">
                                <span class="indicator-label">Continue</span>
                                <span class="indicator-progress d-none">Please wait... 
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Deleteing Modal -->
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#probes-table').DataTable({
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var startIndex = api.page() * api.page.len();
                    
                    // Update numbering on each redraw
                    $(rows).each(function (index) {
                        $(this).find('td:first').html(startIndex + index + 1);
                    });
                }
            });
        });
    </script>

    <script src="{{ asset('mazer/assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('mazer/assets/extensions/datatables.net-bs5/js/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('mazer/assets/static/js/pages/datatables.js') }}"></script> --}}

@endpush