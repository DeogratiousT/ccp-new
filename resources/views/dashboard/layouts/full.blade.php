@extends('dashboard.layouts.app')

@section('page-imports')
    <link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/auth.css') }}" />
@endsection

@section('body')
    <!--begin::Body-->
    <body>
        <script src="{{ asset('mazer/assets/static/js/initTheme.js') }}"></script>
        <div id="auth">
            <div class="row h-100">
                <div class="col-lg-5 col-12">
                    <div id="auth-left">
                        <div class="auth-logo mb-2">
                            <a href="#">
                                <img src="{{ asset('mazer/assets/compiled/png/logo2.png') }}" alt="Logo" style="width: 200px; height: 70px"/>
                            </a>
                        </div>

                        <h1 class="auth-title">@yield('page-title')</h1>

                        <p class="fs-5">
                            @yield('page-description')
                        </p>
    
                        <!-- begin::Status -->
                            @include('dashboard.includes.messages')
                        <!-- end::Status -->

                        <!--begin::Form-->
                            @yield('content')
                        <!--end::Form-->
                
                    </div>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <div id="auth-right"></div>
                </div>
            </div>
        </div>
    </body>
    <!--end::Body-->
@endsection