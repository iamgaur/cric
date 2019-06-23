<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>@yield('title', 'WikiCricInfo')</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <!-- Bootstrap core CSS     -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-3.4.1/css/bootstrap.min.css') }}">

    <!--Optional theme-->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-3.4.1/css/bootstrap-theme.min.css') }}">
 
    <!--Animation library for notifications-->   
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet"/>

    <!--Light Bootstrap Table core CSS-->
    <link href="{{ asset('css/light-bootstrap-dashboard.css?v=1.4.0') }}" rel="stylesheet"/>

    <!--CSS for Demo Purpose, don't include it in your project-->     
    <link href="assets/css/demo.css" rel="stylesheet" />

    <!--Fonts and icons-->     
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/pe-icon-7-stroke.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" />

    <style>
        ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
            color: #808080!important;
        }

        :-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: #808080!important;
        }

        ::-ms-input-placeholder { /* Microsoft Edge */
            color: #808080!important;
        }
        label {
            color:black!important;
        }
    </style>
</head>
<body>
    <div class="wrapper">
	<div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

		<div class="sidebar-wrapper">
			<div class="logo">
				<a href="URL::to('/')" class="simple-text">
                                    {{ env('LOGO_TITLE', 'Creative Tim') }}
				</a>
			</div>
			 @include('Theme::layouts.menu')
		</div>
	</div>
        <div class="main-panel">
            @include('Theme::layouts.mobileMenu')
                @include('Theme::layouts.errors')
                @include('Theme::layouts.success')
                @yield('content')
            @include('Theme::layouts.footer')
        </div>
    </div>
</body>
  
    <!--   Core JS Files   -->    
    <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery.1.11.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datepicker.min.js') }}"></script>

      <!--Charts Plugin--> 
    <script src="{{ asset('js/chartist.min.js') }}"></script>

      <!--Notifications Plugin-->    
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>

     <!--Light Bootstrap Table Core javascript and methods for Demo purpose--> 
    <script src="{{ asset('js/light-bootstrap-dashboard.js?v=1.4.0') }}"></script>

     <!--Light Bootstrap Table DEMO methods, don't include it in your project!--> 
    <script src="{{ asset('js/demo.js') }}"></script>
    @stack('scripts')
</html>