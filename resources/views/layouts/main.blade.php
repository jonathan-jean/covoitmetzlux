<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="assets/img/favicon.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>#CoVoitMetzLux</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{{ asset('assets/css/bootstrap-social.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/animate.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="blue" data-image="{{ asset('assets/img/sidebar.jpg') }}">
        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{ route('home') }}" class="simple-text">
                    #CoVoitMetzLux
                </a>
            </div>

            <ul class="nav">
                <li {{ Request::is('/') ? 'class=active' : '' }}>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                        <p>Accueil</p>
                    </a>
                </li>
                @if(!Auth::check())
                <li>
                    <a href="{{ route('login') }}">
                        <i class="fa fa-users"></i>
                        <p>S'inscrire</p>
                    </a>
                </li>
                <li>
                <a href="{{ route('login') }}">
                        <i class="fa fa-user"></i>
                        <p>Se connecter</p>
                    </a>
                </li>
                @else
                    <li {{ Request::is('travel') ? 'class=active' : '' }}>
                        <a href="{{ route('travel-index') }}">
                            <i class="fa fa-map"></i>
                            <p>Mes trajets</p>
                        </a>
                    </li>
                    <li {{ Request::is('contact') ? 'class=active' : '' }}>
                        <a href="{{ route('contact-index') }}">
                            <i class="fa fa-phone"></i>
                            <p>Demandes de contact</p>
                            @if (auth()->user()->contactRequests()->unanswered()->count())
                             <span class="notification">{{ auth()->user()->contactRequests()->unanswered()->count()  }}</span>
                            @endif
                        </a>
                    </li>
                @endif
                <li {{ Request::is('travel/search') ? 'class=active' : '' }}>
                    <a href="{{ route('travel-search') }}">
                        <i class="fa fa-search"></i>
                        <p>Rechercher un trajet</p>
                    </a>
                </li>
                <li {{ Request::is('travel/create') ? 'class=active' : '' }}>
                    <a href="{{ route('travel-create' )}}">
                        <i class="fa fa-car"></i>
                        <p>Proposer un trajet</p>
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
                                <a href="{{ route('login') }}">
                                    <p>S'inscrire</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}">
                                <p>Se connecter</p>
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('profile') }}">
                                    <p>{{ Auth::user()->name }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route("logout") }}">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/bootstrap-notify.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        @if(session("info"))
            $.notify({
            icon: 'fa fa-info',
            message: "{{ session("info") }}"
        },{
            type: 'info',
            timer: 3000
        });
        @endif

    });
</script>

@yield('script')

</html>
