<x-mail::message>
# Invitation d'équipe

Vous avez été invité à rejoindre l'équipe **{{ $invitation->team->name }}**.

Si vous n'avez pas de compte, vous pourrez en créer un en acceptant cette invitation.

<x-mail::button :url="$url">
Accepter l'invitation
</x-mail::button>

Si vous n'attendiez pas cette invitation, vous pouvez ignorer cet email.

Merci,<br>
{{ config('app.name') }}
</x-mail::message>
