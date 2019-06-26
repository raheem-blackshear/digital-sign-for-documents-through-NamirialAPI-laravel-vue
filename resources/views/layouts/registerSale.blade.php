<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AssyTech</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/css/skins/_all-skins.min.css">

    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/_all.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Vue Materials -->
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">

    @yield('css')
</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top front-end-navbar" role="navigation" style = "margin-left:0">
                    <img class = "logo-image" src = "../../../../assets/img/Assiqura_Logo.png" />
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="../../../../../../assets/img/avatar.png"
                                            class="user-image" alt="User Image"/>
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    @if(Auth::check())
                                    <span class="hidden-xs header-user-name">{!! Auth::user()->first_name !!}</span>
                                    @endif
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="../../../../../../assets/img/avatar.png"
                                                class="img-circle" alt="User Image"/>
                                        @if(Auth::check())
                                        <p>
                                            {!! Auth::user()->name !!}
                                            <small>Membro dal {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                        </p>
                                        @endif
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            @if(Auth::check())
                                            <a href="{{ url('/admin/sales/') }}" class="btn btn-default btn-flat">Riepilogo vendite</a>
                                            @endif
                                        </div>
                                        <div class="pull-right">
                                            @if(Auth::check())
                                                <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    Log out
                                                </a>
                                            @else
                                                <a href="{!! url('/login') !!}" class="btn btn-default btn-flat">
                                                Login
                                                </a>
                                            @endif
                                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
        </header>
        <div class="content-wrapper" style = "margin-left:0px">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center; margin-left:0px; font-size:14px">
            <!--<strong>Copyright © 2018 <a href="https://www.wemteq.com/">WeMTEQ Solutions</a>.</strong> All rights reserved.-->
        </footer>

    </div>

    <!-- jQuery 3.1.1 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.3/js/adminlte.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
    <script type="text/javascript" src="{!! asset('js/app.js') !!}"></script>
    @yield('scripts')
</body>
</html>
