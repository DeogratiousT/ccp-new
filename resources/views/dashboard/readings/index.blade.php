@extends('dashboard.layouts.main')

@section('title','Readings')

@section('page-imports')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"/>
@endsection

@section('page-title', 'Readings')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Readings
        </li>
    </ol>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="readings-table">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th>#</th>
                            <th>Section</th>
                            <th>Probe</th>
                            <th>Value</th>
                            <th>SI Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($readings as $index => $reading)
                            <tr>
                                <td></td>
                                <td>{{ $reading->probe->section->name }}</td>
                                <td>{{ $reading->probe->name }}</td>
                                <td>{{ $reading->value }}</td>
                                <td>{{ $reading->probe->condition->si_unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-body -->
    </div> <!-- end card -->

    @foreach ($readings as $reading)
        <!--start:: Delete Modal -->
        <div class="modal fade" tabindex="-1" id="delete-section-{{ $reading->id }}-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete {{ $reading->name }}</h4>

                        <!--begin::Close-->
                        <button class="btn icon btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body row">
                        <form action="{{ route('dashboard.readings.destroy', $reading) }}" method="POST" id="delete-section-{{ $reading->id }}-form">
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
            $('#readings-table').DataTable({
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