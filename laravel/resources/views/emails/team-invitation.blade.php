@component('mail::message')
# Invitation

Vous avez été invité(e) à rejoindre l'équipe **{{ $invitation->team->name }}** !

@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::registration()))
    Si vous n'avez pas encore de compte, vous pouvez en créer un ci-dessous. Une fois votre compte créé, vous pourrez
    accepter l'invitation en cliquant sur le bouton d'acceptation.

    @component('mail::button', ['url' => route('register')])
    Créer un compte
    @endcomponent

    Si vous avez déjà un compte, vous pouvez accepter l'invitation directement :
@else
    Vous pouvez accepter cette invitation en cliquant sur le bouton ci-dessous :
@endif

@component('mail::button', ['url' => $acceptUrl])
Accepter l'invitation
@endcomponent

Si vous n'attendiez pas d'invitation pour cette équipe, vous pouvez ignorer cet email.
@endcomponent