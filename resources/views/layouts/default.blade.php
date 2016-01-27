<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SF</title>

  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <!-- Fonts -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>

  <link href="/assets/css/fonts.css" rel="stylesheet" type="text/css" />
  <link href="/assets/css/layouts/default.css" rel="stylesheet" type="text/css" />

  @yield('stylesheets')

  <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

<style type="text/css">
  .jumbotron {
    padding-right: 60px !important;
    padding-left: 60px !important;
    }
</style>


<nav class="navbar navbar-default" style="background-color: #17baef;border-color: #17baef;border-radius: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/" style="    padding-top: 3px;">
          <img src="/assets/images/brand_image/perm/sf.png" width="40px">
      </a>

    </div>




    <nav class="navbar navbar-default navbar-fixed-top" style="background-color: #17baef;border-color: #17baef;border-radius: 0px;">  
      <div class="container-fluid"> 
        <div class="navbar-header"> 
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
            data-target="#bs-example-navbar-collapse-6" aria-expanded="false"> 
              <span class="sr-only">Toggle navigation</span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
          </button> 
          <a class="navbar-brand" href="/" style="padding-top: 3px;">
              <img src="/assets/images/brand_image/perm/sf.png" width="40px">
          </a>
        </div> 
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-6">
         <ul class="nav navbar-nav navbar-right"> 
           <li >
           <a href="/">Home</a></li> 
           <li><a href="{!!route('videos_page')!!}">Videos</a></li> 
           <li><a href="{!!route('articles_page')!!}">Articles</a></li> 
         </ul> 
        </div> 
      </div> 
    </nav>


     
  </div>
</nav>


    <div class="container-fluid background-color">
      @include('flash::message')
      @yield('content')

    </div>
{!! View::make('partials.login_modal') !!}
    <!-- Load js libs only when the page is loaded. -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="/packages/Magister3/assets/js/modernizr.custom.72241.js"></script>
    <!-- Custom template scripts -->
    <script src="/packages/Magister3/assets/js/magister.js"></script>

    @yield('scripts')

  </body>
</html>
    <style>

    </style>