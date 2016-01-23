<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Webprinciples</title>

<!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link href="/assets/css/admins/animate.min.css" rel="stylesheet">

    <!-- Custom styling plus plugins -->
    <link href="/assets/css/admins/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/css/admins/maps/jquery-jvectormap-2.0.1.css" />
    <link href="/assets/css/admins/icheck/flat/green.css" rel="stylesheet" />
    <link href="/assets/css/admins/floatexamples.css" rel="stylesheet" type="text/css" />

    <script src="/assets/js/admins/jquery.min.js"></script>
    <script src="/assets/js/admins/nprogress.js"></script>
    <script>
    </script>
      @yield('stylesheets')
    <!--[if lt IE 9]>
        <script src="../assets/js/ie8-responsive-file-warning.js"></script>
        <![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>


<body class="nav-md">

    <div class="container body">

        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">

                    <div class="navbar nav_title" style="border: 0;">
                        <a href="{!! route('admins_index') !!}" class="site_title"> <span>Webprinciples</span></a>
                    </div>
                    <div class="clearfix"></div>

                    <!-- menu prile quick info -->
                    <div class="profile">
                        <div class="profile_pic">
                            <img src="/assets/images/profile-images/perm/{!!$this_user_profile_image!!}" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2>{!! $this_username !!}</h2>
                        </div>
                    </div>
                    <!-- /menu prile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                        <div class="menu_section">
                            <ul class="nav side-menu">
                                <li class="li-menus first-li-m"><a class="first-li-a"><i class="fa fa-edit"></i> Access Control List <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li class="navLi"><a href="{!! route('roles_index') !!}">Roles</a>
                                        </li>
                                        <li class="navLi"><a href="{!! route('permissions_index') !!}">Permissions</a>
                                        </li>
                                        <li class="navLi"><a href="{!! route('permission_roles_index') !!}">Permision Roles</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="li-menus"><a><i class="fa fa-wrench"></i> Control Panel <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li class="navLi"><a href="{!! route('users_index') !!}">Users</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="li-menus"><a><i class="fa fa-clone"></i> Layouts and Pages <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li>Pages</li>
                                        <li class="navLi"><a href="{!! route('pages_index') !!}">Index</a>
                                        </li>
                                        <li class="navLi"><a href="{!! route('pages_add') !!}">Add</a>
                                        </li>
                                        <li>Pages Sliders</li>
                                        <li class="navLi"><a href="{!! route('sliders_index') !!}">Index</a>
                                        </li>
                                        <li class="navLi"><a href="{!! route('sliders_add') !!}">Add</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="li-menus"><a><i class="fa fa-cogs"></i> Website Setting <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li>Website Brand</li>
                                            <li class="navLi"><a href="{!! route('website_brand_index') !!}">Setup</a>
                                            </li>

                                    </ul>
                                </li>  
                                <li class="li-menus"><a><i class="fa fa-calendar"></i> Events <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu" style="display: none">
                                        <li class="navLi"><a href="{!! route('events_index') !!}">View All</a>
                                        </li>
                                        <li class="navLi"><a href="{!! route('events_add') !!}">Add New</a>
                                        </li>
                                    </ul>
                                </li>
  
                            </ul>
                        </div>


                    </div>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    @if(isset($notif))
                                        @if($notif['isset'] == true)
                                            <span class="badge" style="color:#d9534f;background:white">{{$notif['count']}} Task</span>
                                        @endif
                                    @endif
                                    <img src="/assets/images/profile-images/perm/{!!$this_user_profile_image!!}" alt="">{!! $this_username !!}
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li>
                                        <a href="javascript:;">Help</a>
                                    </li>
                                    <li>
                                        @if(Auth::user())
                                        <a href="/admins/logout">
                                            <i class="fa fa-sign-out pull-right"></i> Log Out
                                        </a>
                                        @else
                                        <a href="/admins/login">
                                            <i class="fa fa-sign-out pull-right"></i> Log In
                                        </a>
                                        @endif
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
                <div class="row">
                    @include('flash::message')
                    @yield('content')
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>

    <div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="/assets/js/admins/bootstrap.min.js"></script>

    <!-- chart js -->
    <script src="/assets/js/admins/chartjs/chart.min.js"></script>
    <!-- bootstrap progress js -->
    <script src="/assets/js/admins/progressbar/bootstrap-progressbar.min.js"></script>
    <script src="/assets/js/admins/nicescroll/jquery.nicescroll.min.js"></script>
    <!-- icheck -->
    <script src="/assets/js/admins/icheck/icheck.min.js"></script>


    <script src="/assets/js/admins/custom.js"></script>
        @yield('scripts')

    <!-- flot js -->
    <!--[if lte IE 8]><script type="text/javascript" src="js/excanvas.min.js"></script><![endif]-->



    <!-- /footer content -->
</body>

</html>