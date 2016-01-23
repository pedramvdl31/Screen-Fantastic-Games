<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Goldjewelers</title>

  
<!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">



    <script src="/assets/js/admins/jquery.min.js"></script>

  <link href="/assets/css/layouts/admins_simple.css" rel="stylesheet">

  @yield('stylesheets')

  <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="theme-invert">
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      


        <div class="dropdown">
            <a  role="button" data-toggle="dropdown" class="btn btn-primary menu-left-toggle" data-target="#" href="/page.html">


                  <i class="glyphicon glyphicon-menu-hamburger"></i>


            </a>
        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
              <!-- <li class="divider"></li> -->
              <!-- ##############  -->
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Access Control List</a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('roles_index') !!}">Roles</a>
                  </li>
                  <li><a href="{!! route('permissions_index') !!}">Permissions</a>
                  </li>
                  <li><a href="{!! route('permission_roles_index') !!}">Permision Roles</a>
                  </li>
                </ul>
              </li>
              <!-- ##############  -->
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Control Panel</a>
                <ul class="dropdown-menu">
                    <li><a href="{!! route('users_index') !!}">Users</a>
                    </li>
                </ul>
              </li>
              <!-- ##############  -->
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Layouts and Pages</a>
                <ul class="dropdown-menu">

                  <li class="dropdown-submenu">
                    <a href="#">Layouts</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('layouts_index') !!}">Index</a>
                        </li>
                        <li class="navLi"><a href="{!! route('layouts_add') !!}">Add</a>
                        </li>
                    </ul>
                  </li>

                  <li class="dropdown-submenu">
                    <a href="#">Pages</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('pages_index') !!}">Index</a>
                        </li>
                        <li class="navLi"><a href="{!! route('pages_add') !!}">Add</a>
                        </li>
                    </ul>
                  </li>
                  
                  <li class="dropdown-submenu">
                    <a href="#">Pages Sliders</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('sliders_index') !!}">Index</a>
                        </li>
                        <li class="navLi"><a href="{!! route('sliders_add') !!}">Add</a>
                        </li>
                    </ul>
                  </li>

                </ul>
              </li>


              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Merchandise</a>
                <ul class="dropdown-menu">

                  <li class="dropdown-submenu">
                    <a href="#">Categories</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('category_index') !!}">Index</a>
                        </li>
                        <li class="navLi"><a href="{!! route('category_add') !!}">Add</a>
                        </li>
                    </ul>
                  </li>

                  <li class="dropdown-submenu">
                    <a href="#">Inventories</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('inventory_index') !!}">Index</a>
                        </li>
                        <li class="navLi"><a href="{!! route('inventory_add') !!}">Add</a>
                        </li>
                        <li class="navLi"><a href="{!! route('inventory_order') !!}">Order</a>
                        </li>
                    </ul>
                  </li>
                </ul>
              </li>


              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Billings</a>
                <ul class="dropdown-menu">
                  <li class="dropdown-submenu">
                    <a href="#">Invoices</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('invoice_index') !!}">Index</a>
                        </li>
                        <li class="navLi"><a href="{!! route('invoice_add') !!}">Add</a>
                        </li>
                    </ul>
                  </li>

                  <li class="dropdown-submenu">
                    <a href="#">Tax</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('taxes_index') !!}">Index</a>
                        </li>
                        <li class="navLi"><a href="{!! route('taxes_add') !!}">Add</a>
                        </li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li class="navLi"><a href="{!! route('sales_add') !!}">Sales</a>
              </li>

              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Tags</a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('tags_index') !!}">Roles</a>
                  </li>
                  <li><a href="{!! route('tags_add') !!}">Permissions</a>
                  </li>
                </ul>
              </li>

              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Website Setting</a>
                <ul class="dropdown-menu">
                  <li class="dropdown-submenu">
                    <a href="#">Website Brand</a>
                    <ul class="dropdown-menu">
                        <li class="navLi"><a href="{!! route('website_brand_index') !!}">Setup</a>
                        </li>
                    </ul>
                  </li>
                </ul>
              </li>

              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Q & A</a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('qna_index') !!}">View all</a>
                  </li>
                </ul>
              </li>
              
              <li class="dropdown-submenu">
                <a tabindex="-1" href="#">Reviews</a>
                <ul class="dropdown-menu">
                  <li><a href="{!! route('review_index') !!}">View all</a>
                  </li>
                </ul>
              </li>


            </ul>
        </div>

    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
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
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container">
  @yield('content')
</div>
  

  <!-- Load js libs only when the page is loaded. -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
  <script src="/packages/Magister3/assets/js/modernizr.custom.72241.js"></script>
  <!-- Custom template scripts -->
  <!-- <script src="packages/Magister3/assets/js/magister.js"></script> -->

  @yield('scripts')

</body>
</html>
<style>

</style>