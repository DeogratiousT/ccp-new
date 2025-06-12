@extends('dashboard.layouts.main')

@section('title','Users')

@section('page-imports')
    <link rel="stylesheet" href="{{ asset('mazer/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}"/>
@endsection

@section('page-title', 'Users')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard.home') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Users
        </li>
    </ol>
@endsection

@section('page-action')
    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary m-4">
        <i class="bi bi-plus"></i> New User
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="users-table">
                    <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role(s)</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $index => $user)
                            <tr>
                                <td></td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        @if ($role->name == 'Super Admin')
                                            <span class="badge bg-success">Super Admin</span>
                                        @elseif ($role->name == 'Technical Admin')
                                            <span class="badge bg-primary">Technical Admin</span>
                                        @elseif ($role->name == 'Operational Admin')
                                            <span class="badge bg-secondary">Operational Admin</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if ($user->active == true)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Blocked</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- <button class="btn icon btn-light" data-bs-toggle="modal" data-bs-target="#show-user-{{ $user->id }}-modal">
                                        <i class="bi bi-eye-fill"></i>
                                    </button> --}}

                                    <a href="{{ route('dashboard.users.edit', ['user'=>$user]) }}" class="btn icon btn-primary" data-bs-toggle="tooltip" title="Edit User">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    @if ($user->active == true)
                                        <button class="btn icon btn-danger" data-bs-toggle="modal" data-bs-target="#block-user-{{ $user->id }}-modal">
                                            <i class="bi bi-person-x"></i>
                                        </button>
                                    @else
                                        <button class="btn icon btn-success" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}-modal">
                                            <i class="bi bi-person-check"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> <!-- end card-body -->
    </div> <!-- end card -->

    @foreach ($users as $user)
        <!--start:: Block Modal -->
        <div class="modal fade" tabindex="-1" id="block-user-{{ $user->id }}-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Block {{ $user->name }}</h4>

                        <!--begin::Close-->
                        <button class="btn icon btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body row">
                        <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" id="delete-user-{{ $user->id }}-form">
                            @csrf
                            @method('DELETE')

                            <p>Blocking this user denies him/her access to the system</p>

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
        <!--end:: Blocking Modal -->

        <!--start:: Activate Modal -->
        <div class="modal fade" tabindex="-1" id="activate-user-{{ $user->id }}-modal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Activate {{ $user->name }}</h4>

                        <!--begin::Close-->
                        <div class="btn icon btn-outline-light" data-bs-dismiss="modal" aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </div>
                        <!--end::Close-->
                    </div>

                    <div class="modal-body row">
                        <form action="{{ route('dashboard.users.destroy', $user) }}" method="POST" id="delete-user-{{ $user->id }}-form">
                            @csrf
                            @method('DELETE')

                            <p>Activating this user gives him/her access to the system</p>

                            <button type="submit" class="btn btn-success" onclick="formSubmit(this)">
                                <span class="indicator-label">Continue</span>
                                <span class="indicator-progress d-none">Please wait... 
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end:: Delete Modal -->
    @endforeach
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#users-table').DataTable({
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