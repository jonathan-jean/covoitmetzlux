@component('mail::message')
# Votre demande de contact

Nous avons le plaisir de vous annoncer que votre demande contact a été accepté par {{ $contact->toUser->name }}.

---

### Informations

Nom: {{ $contact->toUser->name }}<br>
Adresse mail: {{ $contact->toUser->email }}<br>
@if($contact->toUser->phone)
Numéro de téléphone: {{ "" . $contact->toUser->phone }}<br>
@else
Aucun numéro de téléphone n'est renseigné<br>
@endif
---

##### Rappel de l'annonce

Départ: {{ $contact->travel->departure }}<br>
Destination: {{ $contact->travel->arrival }}<br>
Date: {{ \Carbon\Carbon::parse($contact->travel->date)->format('d/m/Y H:i') }}<br>

@component('mail::button', ['url' => route('travel-search')])
Voir les autres offres
@endcomponent

@endcomponent