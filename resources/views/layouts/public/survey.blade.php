<!DOCTYPE html>
<html lang="en">
	<head><base href=""/>
		<title>Sistem Maklumat Pelajar Darul Quran</title>
		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('layouts.public.css')
	</head>
	<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-white position-relative app-blank">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
            @yield('content')
            {{-- @include('layouts.public.footer') --}}
			<!--end::Footer Section-->
		</div>
        @include('layouts.public.script')
        @yield('script')
	</body>
</html>
