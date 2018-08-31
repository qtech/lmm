<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<link href="{{asset('app_icon.png')}}" rel="icon" type="image/png">
	
	<title>{{config('app.name')}}</title>	

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script src="{{asset('/assets/js/lib/jquery/jquery.min.js')}}"></script>
	{{-- Summernote editor --}}
	<link rel="stylesheet" href="{{asset('/assets/css/lib/summernote/summernote.css')}}"/>
	<link rel="stylesheet" href="{{asset('/assets/css/separate/pages/editor.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets/css/separate/pages/widgets.min.css')}}">	
	<link rel="stylesheet" href="{{asset('/assets/css/lib/simplemde/simplemde.min.css')}}"/>
	<link rel="stylesheet" href="{{asset('/assets/css/separate/pages/editor.min.css')}}">
	<link rel="stylesheet" href="{{asset('/assets/css/separate/vendor/bootstrap-select/bootstrap-select.min.css')}}">
	<!-- Include Date Range Picker -->	
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
	<link rel="stylesheet" href="{{asset('/assets/css/separate/pages/user.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/lib/font-awesome/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/lib/bootstrap/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('/assets/css/custom.css')}}">
    <style>
        /* For Firefox */
        input[type='number'] {
            -moz-appearance:textfield;
        }
        /* Webkit browsers like Safari and Chrome */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="with-side-menu">

	@include('inc.header')

	<div class="mobile-menu-left-overlay"></div>
	@include('inc.nav')	

	<div class="page-content">
		<div class="container-fluid">
			@include('inc.messages')

			@yield('content')
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	
	<script src="{{asset('/assets/js/lib/tether/tether.min.js')}}"></script>
	<script src="{{asset('/assets/js/lib/bootstrap/bootstrap.min.js')}}"></script>
	<script src="{{asset('/assets/js/plugins.js')}}"></script>
	
	<script src="{{asset('/assets/js/lib/bootstrap-maxlength/bootstrap-maxlength.js')}}"></script>
	<script src="{{asset('/assets/js/lib/bootstrap-maxlength/bootstrap-maxlength-init.js')}}"></script>
	<script src="{{asset('/assets/js/lib/bootstrap-select/bootstrap-select.min.js')}}"></script>
	<script src="{{asset('/assets/js/lib/simplemde/simplemde.min.js')}}"></script>
	<script>
		$(document).ready(function() {
			new SimpleMDE({
				element: document.getElementById("new_event"),
				spellChecker: true,
				placeholder: "Describe your event with as much information as necessary...",
			});	

			new SimpleMDE({
				element: document.getElementById("biography"),
				spellChecker: true,
				placeholder: "Describe your biography...",
			});		
		});
	</script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
	<script type="text/javascript">
		$(function() {
		    $('input[name="daterange"]').daterangepicker({
		    	locale: {
            		format: 'YYYY/MM/DD'
        		}
		    });
		});
		</script>

	<script src="{{asset('/assets/js/lib/summernote/summernote.min.js')}}"></script>
	<script>
		$(document).ready(function() {
			$('.summernote').summernote();
		});
	</script>
	<script src="{{asset('/assets/js/app.js')}}"></script>
</body>
</html>
