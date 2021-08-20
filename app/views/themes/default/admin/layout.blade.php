<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FolkOfLore - Admin CP</title>

    <!-- Bootstrap -->
    {{ HTML::style('assets/css/bootstrap.min.css') }}

    <!-- Custom Style -->
    {{ HTML::style('assets/css/custom.css') }}

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js') }}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      {{ HTML::script('https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js') }}
      {{ HTML::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') }}
    <![endif]-->

    @yield('header')
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">FolkOfLore</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="/">Home</a></li>
          </ul>

          <div class="row navbar-right userinfo">
            <div class="username col-xs-6">
              Welcome, {{ Auth::user()->username }}
            </div>

            <div class="col-xs-3">
              <a href="/admin" class="btn btn-success">Admin CP</a>
            </div>

            <div class="col-xs-3">
              <a href="/user/logout" class="btn btn-primary">Logout</a>
            </div>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
      <div class="custom">
        <div class="row">
          <div class="col-md-3">
            <div class="well">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="/admin">Dashboard</a></li>
                <li><a href="/admin/user">Users</a></li>
                <li><a href="/admin/colors">Colors</a></li>
                <li><a href="/admin/species">Species</a></li>
                <li><a href="/admin/craviary">Craviary</a></li>
                <li><a href="/admin/species/upload">Species Image Upload</a></li>
                <li><a href="/admin/clothing/upload">Clothing Image Upload</a></li>
              </ul>
            </div>
          </div>

          <div class="col-md-9">
            @if(Session::has('errors'))
              <div class="alert alert-danger">
                @if(is_array($errors))
                  @foreach($errors as $error)
                    {{ $error }}<br />
                  @endforeach
                @else
                  {{ $errors }}
                @endif
              </div>
            @endif

            @if(Session::has('success'))
              <div class="alert alert-success">
                {{  Session::get('success') }}
              </div>
            @endif

            @yield('content')
          </div>
        </div>
      </div>
    </div> <!-- /container -->

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    {{ HTML::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js') }}
    {{ HTML::script('assets/js/bootstrap.min.js') }}
  </body>
</html>