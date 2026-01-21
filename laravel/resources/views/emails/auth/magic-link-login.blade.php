@component('mail::message')
# Connexion sans mot de passe

Bonjour,

Vous avez demandé à vous connecter à **{{ config('app.name') }}** sans utiliser de mot de passe.

Cliquez sur le bouton ci-dessous pour accéder directement à votre compte :

@component('mail::button', ['url' => $url])
Me connecter maintenant
@endcomponent

Ce lien est valide pendant **15 minutes**. Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet
email en toute sécurité.

Merci,<br>
L'équipe {{ config('app.name') }}
@endcomponent