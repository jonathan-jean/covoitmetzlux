@extends('layouts.main')

@section("name")
    Informations sur le trajet
@stop

@section("content")
    <div class="row">
        <div class="col-md-8" style="height: 600px;">
           {!! Mapper::render() !!}
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card card-user">
                    <div class="image">
                    </div>
                    <div class="content">
                        <div class="author">
                            <a href="#">
                                <img class="avatar border-gray" src="{{ $travel->user->avatar }}">

                                <h4 class="title">Le trajet<br>
                                    <small>Par {{ $travel->user->name }}</small>
                                </h4>
                            </a>
                            <a href="https://twitter.com/share" class="twitter-share-button" data-text="Nouveau #CoVoitMetzLux au départ de {{ $travel->departure }} le {{ \Carbon\Carbon::parse($travel->date)->format('d/m/Y H:i') }}. + infos: " data-size="large">Tweet</a>
                        </div>
                        <hr>
                        <div class="content">
                            <h6>Date: </h6> <p class="category">{{ \Carbon\Carbon::parse($travel->date)->format('d/m/Y H:i') }}</p>
                            <h6>Départ: </h6> <p class="category">{{ $travel->departure }}</p>
                            <h6>Destination: </h6> <p class="category">{{ $travel->arrival }}</p>
                            <h6>Places disponibles: </h6> <p class="category">{{ $travel->places }}</p>
                            <h6>Message du conducteur: </h6> <p class="category">{{ $travel->information }}</p>
                            <hr>
                            @if (auth()->check())
                                <a href="{{ route('travel-contact', $travel->id) }}" class="btn btn-fill btn-info">Contacter le conducteur</a>
                                @if ($travel->user == auth()->user())
                                    <a href="{{ route('travel-edit', $travel->id) }}" class="btn btn-fill btn-warning">Modifier mon annonce</a>
                                    <a href="{{ route('travel-delete', $travel->id) }}" class="btn btn-fill btn-danger">Supprimer mon annonce</a>
                                @endif
                            @else
                                <p class="category">Pour contacter le conducteur, vous devez être <a href="{{ route('login') }}">connecté</a></p>
                            @endif

                        </div>
                    </div>
            </div>
        </div>
    </div>
@stop

@section('script')
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
@stop