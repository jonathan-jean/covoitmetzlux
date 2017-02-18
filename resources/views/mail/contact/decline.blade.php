@component('mail::message')
# Votre demande de contact

Nous avons le regret de vous annoncer que votre demande contact a été decliné par {{ $contact->toUser->name }}.

---

##### Rappel de l'annonce

Départ: {{ $contact->travel->departure }}<br>
Destination: {{ $contact->travel->arrival }}<br>
Date: {{ \Carbon\Carbon::parse($contact->travel->date)->format('d/m/Y H:i') }}<br>

@component('mail::button', ['url' => route('travel-search')])
Voir les autres offres
@endcomponent

@endcomponent