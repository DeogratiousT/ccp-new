
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<title>{{ env('APP_NAME', 'CCP MONITOR') }} | @yield('title')</title>
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta charset="utf-8" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="" />
		<meta property="og:url" content="" />
		<meta property="og:site_name" content="{{ env('APP_NAME', 'CCP MONITOR') }} | @yield('title')" />
		<link rel="canonical" href="" />
		<link rel="shortcut icon" href="" />

		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->

		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app.css') }}" />
    	<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/app-dark.css') }}" />
    	<link rel="stylesheet" href="{{ asset('mazer/assets/compiled/css/iconly.css') }}" />
		<!--end::Global Stylesheets Bundle-->

		<!--begin::Custom Stylesheets-->
            @yield('page-imports')
		<!--end::Custom Stylesheets-->
	</head>
	<!--end::Head-->

    @yield('body')

</html>