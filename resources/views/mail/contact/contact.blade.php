@component('mail::message')
# Une nouvelle demande de contact

Un utilisateur a demandé a vous contacter.

@component('mail::button', ['url' => route('contact-index')])
Voir
@endcomponent

@endcomponent