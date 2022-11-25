<!DOCTYPE html>
<html lang="en">
	<head><base href=""/>
		<title>Metronic - the world's #1 selling Bootstrap Admin Theme Ecosystem for HTML, Vue, React, Angular & Laravel by Keenthemes</title>
		<meta charset="utf-8" />
		<meta name="description" content="The most advanced Bootstrap Admin Theme on Themeforest trusted by 100,000 beginners and professionals. Multi-demo, Dark Mode, RTL support and complete React, Angular, Vue, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel versions. Grab your copy now and get life-time updates for free." />
		<meta name="keywords" content="metronic, bootstrap, bootstrap 5, angular, VueJs, React, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel starter kits, admin themes, web design, figma, web development, free templates, free admin themes, bootstrap theme, bootstrap template, bootstrap dashboard, bootstrap dak mode, bootstrap button, bootstrap datepicker, bootstrap timepicker, fullcalendar, datatables, flaticon" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="Metronic | Bootstrap HTML, VueJS, React, Angular, Asp.Net Core, Rails, Spring, Blazor, Django, Flask & Laravel Admin Dashboard Theme" />
		<meta property="og:url" content="https://keenthemes.com/metronic" />
		<meta property="og:site_name" content="Keenthemes | Metronic" />
        @include('layouts.public.css')
        <style>
            .swal2-icon-success {
            background-color: #a5dc86 !important;
            }

            .swal2-icon-error {
            background-color: #f27474 !important;
            }

            .swal2-icon-warning {
            background-color: #f8bb86 !important;
            }

            .swal2-icon-info {
            background-color: #3fc3ee !important;
            }

            .swal2-icon-question {
            background-color: #87adbd !important;
            }

            .swal2-title {
            color: white !important;
            }

            .swal2-title {
            color: white !important;
            }

            .swal2-close {
            color: white !important;
            }

            .swal2-html-container {
            color: white !important;
            }
        </style>
	</head>
	<body id="kt_body" data-bs-spy="scroll" data-bs-target="#kt_landing_menu" class="bg-white position-relative app-blank" style="background-color: #eaedf7 !important">
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			<div class="mb-0" id="home">
				<div class="bgi-no-repeat bgi-size-contain bgi-position-x-center bgi-position-y-bottom landing-dark-bg">
					<div class="landing-header" data-kt-sticky="true" data-kt-sticky-name="landing-header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<div class="container">
							<div class="d-flex align-items-center justify-content-between">
								<div class="d-flex align-items-center flex-equal">
									<button class="btn btn-icon btn-active-color-primary me-3 d-flex d-lg-none" id="kt_landing_menu_toggle">
										<span class="svg-icon svg-icon-2hx">
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z" fill="currentColor" />
												<path opacity="0.3" d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z" fill="currentColor" />
											</svg>
										</span>
									</button>
									<a href="../../demo1/dist/landing.html">
										<img alt="Logo" src="assets/media/logos/landing.svg" class="logo-default h-25px h-lg-30px" />
										<img alt="Logo" src="assets/media/logos/landing-dark.svg" class="logo-sticky h-20px h-lg-25px" />
									</a>
								</div>
								@include('layouts.public.navigation')
								<div class="flex-equal text-end ms-1">
									<a href="{{ route('login') }}" class="btn btn-success">Log Masuk</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            @yield('content')
            @include('layouts.public.footer')
		</div>
        @include('layouts.public.script')
        @yield('script')
	</body>
</html>
