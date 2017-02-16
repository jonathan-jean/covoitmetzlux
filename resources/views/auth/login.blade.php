@extends("layouts.main")

@section("name")
    S'inscrire ou se connecter
@stop
@section("content")
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="card card-user">
                <div class="header">
                    <h4 class="title">Connexion et inscription</h4>
                </div>
                <hr>
                <div class="content">
                    <a class="btn btn-block btn-social btn-facebook btn-md" href="{{ url("auth/facebook") }}">
                        <span class="fa fa-facebook"></span> Connexion avec Facebook
                    </a>
                    <hr>
                    <a class="btn btn-block btn-social btn-twitter btn-md" href="{{ url("auth/twitter") }}">
                        <span class="fa fa-twitter"></span> Connexion avec Twitter
                    </a>
                    <hr>
                    <a class="btn btn-block btn-social btn-google btn-md" href="{{ url("auth/google") }}">
                        <span class="fa fa-google"></span> Connexion avec Google
                    </a>
                </div>
                <hr>
                <div class="text-center">
                    <p class="small">C'est simple, rapide et sécurisé!</p>
                </div>
            </div>
        </div>
    </div>
@stop

