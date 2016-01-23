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
  <link href='/packages/jquery-ui-1.11.4.custom/jquery-ui.min.css' rel='stylesheet' type='text/css'>
  <link href='/assets/css/layouts/general.css' rel='stylesheet' type='text/css'>
  <link href='/assets/css/layouts/customize.css' rel='stylesheet' type='text/css'>
  <link href='/assets/css/design_tools/checkbox.css' rel='stylesheet' type='text/css'>
  <link href='/assets/css/login_modal.css' rel='stylesheet' type='text/css'>
  <link type="text/css" rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" />
<link type="text/css" rel="stylesheet" href="http://gregfranko.com/jquery.selectBoxIt.js/css/jquery.selectBoxIt.css" />
  @yield('stylesheets')

    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
  </head>
        <body class="theme-invert">
            <nav class="navbar navbar-default" data-spy="affix" id="nav">
                <div class="container-fluid inside-nav-holder" style="">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header my-header col-md-2 text-center" style="margin: 0 !important;">
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                        <img  class="brand-img back-to-home" src="/assets/images/brand_image/perm/{{$website_brand->brand_img_src}}"  height='55px'>
                        <p class="brand-title back-to-home">{{$website_brand->title}}</p>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="navbar-collapse-1" style="">
                        <ul id="layout-option-holder" class="col-md-7">
                            @foreach($layout_titles as $layout_title)
                                <div class="col-md-4 col-sm-2 first-rdo rdo-group font-open-sans" style="margin-top: -11px;">
                                  <label for="{!! $layout_title->title !!}" class="radio-label">
                                    <input this-href="{!! $layout_title->lowered !!}/{!! $layout_title->id !!}" 
                                    @if(isset($prefered_layout['strtolow_title']))
                                        @if($layout_title->lowered == $prefered_layout['strtolow_title'])
                                            checked
                                        @endif
                                    @endif
                                    class="layout-btn rdo-group-input" type="radio" value="pretty" 
                                    ame="quality" id="{!! $layout_title->title !!}"
                                    > <span class="rdo-group-input ">{!! $layout_title->title !!}</span>
                                    </label>
                                </div>
                            @endforeach
                        </ul>
                        <ul id="layout-select-holder" class="col-md-7">

                            <select class="form-control" id="layout-option-select">
                                @foreach($layout_titles as $layout_title)
                                  <option 
                                    @if(isset($prefered_layout['strtolow_title']))
                                        @if($layout_title->lowered == $prefered_layout['strtolow_title'])
                                            selected="selected"
                                        @endif
                                    @endif
                                   value="{!! $layout_title->lowered !!}/{!! $layout_title->id !!}">{!! $layout_title->title !!}</option>
                                @endforeach
                            </select>


                        </ul>
                        <ul class="nav navbar-nav navbar-right col-md-5 col-sm-7 icon-holder">
                            <li class="indi-icon-li pull-right">
                                <a href="#" class="no-padding-top vpscu_icons"><i class="glyphicon glyphicon-facetime-video"></i></a>
                            </li>
                            <li class="indi-icon-li pull-right">
                                <a href="#" class="vpscu_icons no-padding-top"><i class="glyphicon glyphicon-pushpin"></i></a>
                            </li>
                            <li id="liked-li" class="indi-icon-li pull-right">
                                @if(isset($liked_session_items['all_count']))
                                    @if($liked_session_items['all_count'] > 0)
                                        <span class="badge like-badge" style="">{{$liked_session_items['all_count']}}</span>
                                        <a type="button" class="no-padding-top btn btn-default dropdown-toggle vpscu-toogle clearfix vpscu_icons" style=""
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="glyphicon glyphicon-star liked-heart liked-icon"></i><span class="caret caret-cls"></span> 
                                            <span class="badge like-badge-toogle" style="display:none">{{$liked_session_items['all_count']}}</span>
                                        </a>
                                    @endif 
                                @else
                                    <span class="badge like-badge" style=""></span>
                                    <a type="button" class="no-padding-top btn btn-default dropdown-toggle vpscu-toogle clearfix vpscu_icons" style=""
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="glyphicon glyphicon-star-empty liked-heart liked-icon"></i>
                                    </a>
                                @endif 
                                <ul class="dropdown-menu vpscu-icons-dropdown">
                                    @if(isset($liked_session_items))
                                        @foreach($liked_session_items as $litemskey => $litems)
                                            @if($litemskey != 'all_count' )
                                                <li class="pull-right col-md-12 col-sm-12 col-xs-12 vpscu-icons-li">
                                                    <a class="clearfix col-md-12 vpscu-dropdown-a" style="">
                                                    <div class="col-md-4" style="padding-left: 0;padding-right: 0;">
                                                        @if(isset($litems['primary_image'][0]))
                                                            <img class="" src="/assets/images/inventories/perm/{{$litems['primary_image'][0]}}" height="70px" width="70px"  alt="">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6" style="white-space: normal;padding-left: 0;margin-top:20px;">
                                                        @if(isset($litems['item_title']))
                                                            {{$litems['item_title']}}
                                                        @endif
                                                    </div>  
                                                    <div class="col-md-2" style="padding-left: 0;padding-right: 4px;">
                                                        <!-- delete-item-cart -->
                                                        <i class="glyphicon glyphicon-remove-circle delete-single-item-liked pull-right" item-id="{{$litems['item_id']}}"  style="font-size: 18px;color: #4B4B4B;"></i>
                                                    </div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if(isset($liked_session_items))
                                        <li class="">
                                            <a href="{!!route('reset-liked')!!}">Delete all likes</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            <li id="cart-li" class="indi-icon-li pull-right">
                                @if(isset($cart_session_items['all_count']))
                                    @if($cart_session_items['all_count'] > 0)
                                        <span class="badge cart-badge" style="">{{$cart_session_items['all_count']}}</span>
                                        <a type="button" class="no-padding-top btn btn-default dropdown-toggle vpscu-toogle clearfix vpscu_icons" style=""
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="glyphicon glyphicon-shopping-cart cart-icon"></i><span class="caret caret-cls"></span>
                                        <span class="badge cart-badge-toogle" style="display:none">{{$cart_session_items['all_count']}}</span>
                                        </a>
                                    @endif
                                @else
                                    <span class="badge cart-badge" style=""></span>
                                    <a type="button" class="no-padding-top btn btn-default dropdown-toggle vpscu-toogle clearfix vpscu_icons" style=""
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="glyphicon glyphicon-shopping-cart cart-icon"></i>
                                    </a>
                                @endif
                                <ul class="dropdown-menu vpscu-icons-dropdown">
                                    @if(isset($cart_session_items))
                                        @foreach($cart_session_items as $citemskey => $citems)
                                            @if($citemskey != 'all_count' )
                                                <li class="pull-right col-md-12 col-sm-12 col-xs-12 vpscu-icons-li">
                                                    <a class="clearfix col-md-12 vpscu-dropdown-a" style="">
                                                        <div class="col-md-4" style="padding-left: 0;padding-right: 0;">
                                                            <img class="" src="/assets/images/inventories/perm/{{$citems['primary_image'][0]}}" height="70px" width="70px"  alt="">
                                                        </div>
                                                        <div class="col-md-6" style="white-space: normal;padding-left: 0;margin-top:20px;">
                                                            {{$citems['item_title']}}&nbsp({{$citems['item_count']}})
                                                        </div>  
                                                        <div class="col-md-2" style="padding-left: 0;padding-right: 4px;">
                                                            <!-- delete-item-cart -->
                                                            <i class="glyphicon glyphicon-remove-circle delete-single-item-cart pull-right" item-id="{{$citems['item_id']}}"  style="font-size: 18px;color: #4B4B4B;"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    @endif
                                    @if(isset($cart_session_items['all_count']))
                                        <li class="">
                                            <a class=" " style="cursor:pointer" href="{!! route('invoice_checkout') !!}">Checkout</a>
                                        </li>
                                        <li class="">
                                            <a href="{!!route('reset-cart')!!}">Reset all Cart Content</a>
                                        </li>
                                    @endif
                                </ul>
                            </li>
                            @if(Auth::check())
                                <li class="pull-right indi-icon-li">
                                    <div class="btn-group ">
                                        <button type="button" class="no-padding-top btn btn-default dropdown-toggle clearfix vpscu_icons" style=""
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="glyphicon glyphicon-user user-icon" style="color:#5cb85c"></i><span class="caret caret-cls"></span>
                                        </button>
                                        <ul class="dropdown-menu vpscu-icons-dropdown">
                                            <li><a class="logout-btn" style="cursor:pointer">Logout</a></li>
                                            <li><a href="#">Edit Profile</a></li>
                                            <li><a href="#">Address book</a></li>
                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li class="pull-right indi-icon-li">
                                    <a class="vpscu_icons no-padding-top"><i class="glyphicon glyphicon-user login-btn"></i></a>
                                </li>
                            @endif
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>



        @yield('content')
        @if(Auth::check())
        {!! View::make('partials.logout_modal') !!}
        @else
        {!! View::make('partials.login_modal') !!}
        @endif
        {!! View::make('partials.success_cart') !!}
        <!-- Load js libs only when the page is loaded. -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="/packages/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="/packages/Magister3/assets/js/modernizr.custom.72241.js"></script>
        <!-- Custom template scripts -->
        <script src="/packages/smart_scroll/smart_scroll.js"></script>

        <script src="/assets/js/design_tools/checkbox.js"></script>

        <script src="/assets/js/layouts/customize_layout.js"></script>

        <script src="/assets/js/login_modal.js"></script>

        <script src="/packages/selectboxit/selectboxit.js"></script>

        

        @yield('scripts')


        </body>
</html>
<style>

</style>