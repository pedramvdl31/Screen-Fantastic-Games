<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>UBU</title>

  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Fonts -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Wire+One' rel='stylesheet' type='text/css'>

    <!-- LAYOUT CSS -->
    <link href='/assets/css/layouts/indexes/main.css' rel='stylesheet' type='text/css'>
    <link href='/assets/css/design_tools/checkbox.css' rel='stylesheet' type='text/css'>
    <link href='/assets/css/login_modal.css' rel='stylesheet' type='text/css'>

    @yield('stylesheets')

    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="theme-invert">

@if(isset($item))
  <div class="container-fluid"  style="padding:0">
@else 
  <div class="container-fluid original" data-spy="affix" data-offset-top="400" id="nav" style="padding:0">
@endif

    <nav class="navbar navbar-default main-nav original-nav">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      
          <img  class="brand-img back-to-home" src="/assets/images/brand-image.png" alt="">
          <p class="brand-title back-to-home">UBU</p>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse g-nav-collapse radio-title-size" id="bs-example-navbar-collapse-1">



        @foreach($layout_titles as $layout_title)
                    <div class="col-md-2 col-sm-2 first-rdo rdo-group font-open-sans" style="padding-left:80px">
                      <label for="{!! $layout_title->title !!}">
                        <input this-href="{!! $layout_title->title !!}" class="layout-btn rdo-group-input" type="radio" value="pretty" 
                        ame="quality" id="{!! $layout_title->title !!}"
                          @if($layout_title->lowered == $param1_lowered)
                            checked
                          @endif 
                            > <span class="rdo-group-input">{!! $layout_title->title !!}</span>
                      </label>
                    </div>
        @endforeach
        


          <form class="navbar-form navbar-left" role="search">

          </form>
          <ul class="nav navbar-nav navbar-right nav-right-icons">
           <li><a href="#"><i class="glyphicon glyphicon-facetime-video"></i></a></li>
           <li><a href="#"><i class="glyphicon glyphicon-pushpin"></i></a></li>
           <li>



            @if($this_slug == 'engagement')

              @if(isset($like_session_count))
                @if($like_session_count > 0)
                  <span class="badge like-badge" style="">{{$like_session_count}}</span>
                  <a href="#"><i class="glyphicon glyphicon-heart liked-heart"></i></a>
                @else
                  <span class="badge like-badge" style=""></span>
                  <a href="#"><i class="glyphicon glyphicon-heart-empty liked-heart"></i></a>
                @endif
              @endif   

            @else 

              @if(isset($like_session_count))
                @if($like_session_count > 0)
                  <span class="badge like-badge" style="">{{$like_session_count}}</span>
                  <a href="#"><i class="glyphicon glyphicon-star liked-heart"></i></a>
                @else
                  <span class="badge like-badge" style=""></span>
                  <a href="#"><i class="glyphicon glyphicon-star-empty liked-heart"></i></a>
                @endif
              @endif 

            @endif

            </li>

           <li>
            
            @if(isset($cart_session_count))
              @if($cart_session_count > 0)
                <span class="badge cart-badge" style="">{{$cart_session_count}}</span>
              @else
                <span class="badge cart-badge" style=""></span>
              @endif
            @endif
            <a href="{!! route('invoice_checkout') !!}"><i class="glyphicon glyphicon-shopping-cart"></i></a></li>

           <li><a href="#"><i class="glyphicon glyphicon-user login-btn"></i></a></li>
          </ul>


        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <nav class="navbar navbar-default main-nav-affix aff-nav hide">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
      
          <img  class="brand-img-affix back-to-home" src="/assets/images/brand-image.png" alt="">
          <p class="brand-title-affix back-to-home">Gold Jewxxelers</p>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse g-nav-collapse radio-title-size" id="bs-example-navbar-collapse-1">



        @foreach($layout_titles as $layout_title)
                    <div class="col-md-2 col-sm-2 first-rdo rdo-group-affix font-open-sans" style="padding-left:80px">
                      <label for="{!! $layout_title->title !!}">
                        <input this-href="{!! $layout_title->title !!}" class="layout-btn rdo-group-input-affix" type="radio" value="pretty" 
                        ame="quality" id="{!! $layout_title->title !!}"
                          @if($layout_title->lowered == $param1_lowered)
                            checked
                          @endif 
                            > <span class="rdo-group-input-affix">{!! $layout_title->title !!}</span>
                      </label>
                    </div>
        @endforeach
        


          <form class="navbar-form navbar-left" role="search">

          </form>
          <ul class="nav navbar-nav navbar-right nav-right-icons-affix">
           <li><a href="#"><i class="glyphicon glyphicon-facetime-video"></i></a></li>
           <li><a href="#"><i class="glyphicon glyphicon-pushpin"></i></a></li>
           <li>



            @if($this_slug == 'engagement')

              @if(isset($like_session_count))
                @if($like_session_count > 0)
                  <span class="badge like-badge" style="">{{$like_session_count}}</span>
                  <a href="#"><i class="glyphicon glyphicon-heart liked-heart"></i></a>
                @else
                  <span class="badge like-badge" style=""></span>
                  <a href="#"><i class="glyphicon glyphicon-heart-empty liked-heart"></i></a>
                @endif
              @endif   

            @else 

              @if(isset($like_session_count))
                @if($like_session_count > 0)
                  <span class="badge like-badge" style="">{{$like_session_count}}</span>
                  <a href="#"><i class="glyphicon glyphicon-star liked-heart"></i></a>
                @else
                  <span class="badge like-badge" style=""></span>
                  <a href="#"><i class="glyphicon glyphicon-star-empty liked-heart"></i></a>
                @endif
              @endif 

            @endif

            </li>

           <li>
            
            @if(isset($cart_session_count))
              @if($cart_session_count > 0)
                <span class="badge cart-badge" style="">{{$cart_session_count}}</span>
              @else
                <span class="badge cart-badge" style=""></span>
              @endif
            @endif
            <a href="{!! route('invoice_checkout') !!}"><i class="glyphicon glyphicon-shopping-cart"></i></a></li>

           <li><a href="#"><i class="glyphicon glyphicon-user login-btn"></i></a></li>
          </ul>


        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>





  </div>

@if($this_slug == 'engagement')
  <input type="hidden" id="like-icon-type" value="heart">
@else
  <input type="hidden" id="like-icon-type" value="star">
@endif

  @yield('content')
  {!! View::make('partials.login_modal') !!}
  {!! View::make('partials.add_to_cart_modal') !!}
  <!-- Load js libs only when the page is loaded. -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="/packages/Magister3/assets/js/modernizr.custom.72241.js"></script>
  <!-- Custom template scripts -->
  <script src="/packages/smart_scroll/smart_scroll.js"></script>

  <script src="/assets/js/design_tools/checkbox.js"></script>

  <script src="/assets/js/layouts/indexes/main.js"></script>

  <script src="/assets/js/login_modal.js"></script>

  @yield('scripts')

</body>
</html>
<style>

</style>