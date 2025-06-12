@extends('dashboard.layouts.app')

@section('body')
	<body>
		<script src="{{ asset('mazer/assets/static/js/initTheme.js') }}"></script>
		<div id="app">
		<!--begin::sidebar-->
			@include('dashboard.includes.sidebar')
		<!--end::sidebar-->
		<div id="main" class="layout-navbar navbar-fixed">
			<!--begin::sidebar-->
				@include('dashboard.includes.topbar')
			<!--end::sidebar-->
			<div id="main-content" class="pt-0">
				<div class="page-heading">
					<div class="page-title">
						<div class="row pb-2">
							<div class="col-12 col-md-6 order-md-1 order-first">
								<h3 class="mb-0">
									<!--begin::Main Content-->
										@yield('page-title')
									<!--end::Main Content-->
								</h3>
								<nav aria-label="breadcrumb" class="breadcrumb-header float-start">
									<!--begin::Main Content-->
										@yield('breadcrumb')
									<!--end::Main Content-->
								</nav>
							</div>
							<div class="col-12 col-md-6 order-md-2 order-last">
								<div class="float-start float-lg-end">
									<!--begin::Main Content-->
										@yield('page-action')
									<!--end::Main Content-->
								</div>
							</div>
						</div>
					</div>
					<!--begin::Main Content-->
						@yield('content')
					<!--end::Main Content-->
				</div>				
			</div>

			<!--begin::Footer-->
				@include('dashboard.includes.footer')
			<!--end::Footer-->
			</div>
		</div>

		<!--begin::Scripts -->
			@include('dashboard.includes.scripts')
		<!--end::Scripts -->
  </body>
@endsection