@extends('layouts.main')

@section("name")
    Mes demandes de contacts
@stop

@section("content")
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h4 class="title">Mes demandes de contacts</h4>
                <p class="category">Afin que les usagers puissent recevoir un mail avec vos coordonnées, vous devez accepter la demande de contact.<br>
                Par défaut, seul votre adresse mail sera envoyé, si vous souhaitez envoyer votre numéro de téléphone, il vous suffit de la remplir sur votre
                    <a href="{{ route('profile') }}">profil</a></p>
            </div>
            @if(auth()->user()->contactRequests()->unanswered()->count() > 0)
            <div class="content table-responsive table-full-width">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Trajet</th>
                            <th>Utilsateur</th>
                            <th>Accepter</th>
                            <th>Rejeter</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(auth()->user()->contactRequests()->unanswered()->get() as $contact)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($contact->travel->date)->format('d/m/Y H:i') }}</td>
                            <td>{{ $contact->fromUser->name }}</td>
                            <td><a class="btn btn-success btn-bg btn-xs" href="{{ route('contact-accept', $contact->id) }}"><span class="fa fa-check"></span></a></td>
                            <td><a class="btn btn-danger btn-bg btn-xs" href="{{ route('contact-decline', $contact->id) }}"><span class="fa fa-times"></span></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="content">
                <p>Vous n'avez proposé aucune demande de contact en attente.</p>
            </div>
            @endif
        </div>
    </div>
@stop