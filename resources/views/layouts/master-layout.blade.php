<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>UBU</title>

  <link rel="shortcut icon" href="/assets/images/gt_favicon.png">
  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


  <!-- Fonts -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>
  
  @yield('stylesheets')

  <!-- Custom styles -->
  <link rel="stylesheet" href="/assets/css/layouts/master.css">

  <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body >
  <nav class="navbar navbar-default" style="background-color: #17baef;border-color: #17baef;border-radius: 0px;">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" href="/" style="    padding-top: 3px;">
            <img src="/assets/images/brand_image/perm/sf.png" width="40px">
        </a>

      </div>
    </div>
  </nav>

    <div class="container-fluid background-color max-height" id="wrapper">
      @include('flash::message')
      @yield('content')
    </div>

    <!-- Load js libs only when the page is loaded. -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/packages/Magister3/assets/js/modernizr.custom.72241.js"></script>
    <!-- Custom template scripts -->
    
    <script src="/packages/smart_scroll/smart_scroll.js"></script>
    <script src="/assets/js/layouts/master.js"></script>
    @yield('scripts')

  </body>
</html>
    <style>

    </style>