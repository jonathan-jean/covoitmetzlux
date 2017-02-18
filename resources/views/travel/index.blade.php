@extends('layouts.main')

@section("name")
    Mes trajets
@stop

@section("content")
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Mes trajets</h4>
                <p class="category">Retrouvez ici tout vos trajets.</p>
            </div>
            @if(auth()->user()->travels()->count() > 0)
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Date de départ</th>
                            <th>Départ</th>
                            <th>Destination</th>
                            <th>Places restantes</th>
                            <th>Voir</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(auth()->user()->travels as $travel)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($travel->date)->format('d/m/Y H:i') }}</td>
                            <td>{{ $travel->departure }}</td>
                            <td>{{ $travel->arrival }}</td>
                            <td>{{ $travel->places }}</td>
                            <td><a class="btn btn-xs" href="{{ route('travel-details', $travel->id) }}"><span class="fa fa-search"></span></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="content">
                <p>Vous n'avez proposé aucun trajets jusqu'à maintenant.</p>
            </div>
            @endif
        </div>
    </div>
@stop