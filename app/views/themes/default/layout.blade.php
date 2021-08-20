<!DOCTYPE html>
<!--[if lte IE 6]><html class="preIE7 preIE8 preIE9"><![endif]-->
<!--[if IE 7]><html class="preIE8 preIE9"><![endif]-->
<!--[if IE 8]><html class="preIE9"><![endif]-->
<!--[if gte IE 9]><!--><html><!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="author" content="Folk of Lore">
    <meta name="description" content="Description here">
    <meta name="keywords" content="keywords,here">

    <title>
        @section('title')
            Folk of Lore
        @show
    </title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">

    {{ HTML::style('assets/css/bootstrap.min.css') }}

    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/custom.css?av={{ mt_rand() }}" />
    {{ HTML::style('assets/css/app.css') }}
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      {{ HTML::script('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js') }}
      {{ HTML::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}
    <![endif]-->

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- Google analytics here -->
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    

    @yield('header')
</head>
<body>

<div id="app" class="box">
    @include('themes.default.banner')
    @include('themes.default.navbar')
    <div id="container">
        @include('themes.default.sidebar')
        <div id="content">
            <div>
                @if(Session::has('success'))
    			  <div class="alert alert-success" role="alert">
    			    <div class="col-md-12" style="text-align: center;">
    			        <span style="color: green;">Success! {{ Session::get('success') }}</span>
    			    </div>
    			  </div>
    			@endif
    			
    			@if(Session::has('errors'))
    			    @if(is_array($errors))
        			    @foreach(Session::get('errors') AS $error)
            			  <div class="row">
            			    <div class="col-md-12" style="margin-top: 20px; text-align: center;">
            			        <span style="color: #ff0000;">Error! {{ $error }}</span>
            			    </div>
            			  </div>
        			    @endforeach
        			@else
        			    <div class="row">
            			    <div class="col-md-12" style="margin-top: 20px; text-align: center;">
            			        <span style="color: #ff0000;">Error! {{ $errors }}</span>
            			    </div>
            			  </div>
        			@endif
    			@endif
			
                @yield('content')
            </div>
            @include('themes.default.footer')
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.5.3/modernizr.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js"></script>
{{ HTML::script('assets/js/app.js') }}
<script src="{{ url('/') }}/assets/js/main.js?v={{ mt_rand() }}"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
@yield('scripts')
</body>
</html>