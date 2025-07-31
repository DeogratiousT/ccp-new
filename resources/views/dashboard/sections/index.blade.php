@extends('dashboard.layouts.main')

@section('title','Sections')

@section('page-imports')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"/>
@endsection

@section('page-title', 'Sections')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Sections
        </li>
    </ol>
@endsection

@section('page-action')
    <a href="{{ route('dashboard.sections.create') }}" class="btn btn-primary m-4">
        <i class="bi bi-plus"></i> New Section
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="sections-table">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>MQ Exchange</th>
                            <th>MQ Queue</th>
                            <th>No. of Queues</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sections as $index => $section)
                            <tr>
                                <td></td>
                                <td>{{ $section->name }}</td>
                                <td>{{ $section->slug }}</td>
                                <td>{{ $section->rabbitmq_exchange }}</td>
                                <td>{{ $section->rabbitmq_queue }}</td>
                                <td>{{ count($section->probes) }}</td>
                                <td>
                                    <a href="{{ route('dashboard.sections.probes.index', $section) }}" class="btn icon btn-light">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>

                                    <a href="{{ route('dashboard.sections.edit', ['section'=>$section]) }}" class="btn icon btn-primary" data-bs-toggle="tooltip" title="Edit Section">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <button class="btn icon btn-danger" data-bs-toggle="modal" data-bs-target="#delete-section-{{ $section->id }}-modal">
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

    @foreach ($sections as $section)
        <!--start:: Delete Modal -->
        <div class="modal fade" tabindex="-1" id="delete-section-{{ $section->id }}-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete {{ $section->name }}</h4>

                        <!--begin::Close-->
                        <button class="btn icon btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body row">
                        <form action="{{ route('dashboard.sections.destroy', $section) }}" method="POST" id="delete-section-{{ $section->id }}-form">
                            @csrf
                            @method('DELETE')

                            <p>Are you sure that you want to delete this Section?</p>

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
            $('#sections-table').DataTable({
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