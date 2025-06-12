@if (session('status'))
    <!--begin::Alert-->
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Content-->
            <span>{{ session('status') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <!--end::Alert-->
@endif

@if (session('success'))
    <!--begin::Alert-->
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Content-->
            <span>{{ session('success') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <!--end::Alert-->
@endif

@if (session('error'))
    <!--begin::Alert-->
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Content-->
            <span>{{ session('error') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <!--end::Alert-->
@endif