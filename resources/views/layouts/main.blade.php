<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Light Bootstrap Dashboard by Creative Tim</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap-social.css" rel="stylesheet" />
    <link href="assets/css/animate.min.css" rel="stylesheet"/>
    <link href="assets/css/dashboard.css" rel="stylesheet"/>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="assets/img/sidebar.jpg">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ url('/home') }}" class="simple-text">
                    #CoVoitMetzLux
                </a>
            </div>

            <ul class="nav">
                <li {{ Request::is('home') ? 'class=active' : '' }}>
                    <a href="{{ url('/home') }}">
                        <i class="fa fa-home"></i>
                        <p>Accueil</p>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/login') }}">
                        <i class="fa fa-users"></i>
                        <p>S'inscrire</p>
                    </a>
                </li>
                <li>
                <a href="{{ url('/login') }}">
                        <i class="fa fa-user"></i>
                        <p>Se connecter</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation-example-2">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"> @yield("name", "Accueil") </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        @if(!Auth::check())
                            <li>
                                <a href="{{ url('/login') }}">
                                    <p>S'inscrire</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/login') }}">
                                <p>Se connecter</p>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="">
                                    <p>{{ Auth::user()->name }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url("/auth/logout") }}">
                                    <p>Deconnexion</p>
                                </a>
                            </li>
                        @endif
                        <li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="content">
            <div class="container-fluid">
                @yield("content")
            </div>
        </div>
    </div>
</div>

</body>

<script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap-checkbox-radio-switch.js"></script>
<script src="assets/js/bootstrap-notify.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="assets/js/dashboard.js"></script>

</html>
