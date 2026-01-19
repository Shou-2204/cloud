<x-mail::message>
# Demande de désabonnement

Bonjour,

Une demande de désabonnement vient d'être effectuée pour l'organisation **{!! $team->name !!}**.

---

## 📋 Détails de la demande

@component('mail::table')
| Information | Détail |
|:-------------|:--------|
| **Organisation** | {!! $team->name !!} |
| **Utilisateur** | {!! $userName !!} |
| **Email** | <a href="mailto:{!! $userEmail !!}">{!! $userEmail !!}</a> |
@endcomponent

---

## 📝 Raison du départ

@php
$reasonLabel = match ($reason) {
    'too_expensive' => '💰 Le service est trop cher',
    'missing_features' => '🔧 Fonctionnalités manquantes',
    'bugs' => '🐛 Trop de problèmes techniques',
    'other' => '📝 Autre raison',
    default => $reason
};
@endphp

<x-mail::panel>
<strong>{!! $reasonLabel !!}</strong>
</x-mail::panel>

---

## 📞 Contact

@if($contactAllowed)
<div style="text-align: center; margin: 20px 0;">
    <p style="margin-bottom: 15px;">✅ <strong>L'utilisateur accepte d'être recontacté.</strong></p>
    <x-mail::button :url="'mailto:' . $userEmail . '?subject=Retour sur votre désabonnement'">
        Contacter {!! $userName !!}
    </x-mail::button>
</div>
@else
<div style="background-color: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; text-align: center;">
    ❌ <strong>L'utilisateur ne souhaite pas être recontacté.</strong>
</div>
@endif

---

Cordialement,<br>
L'équipe {!! config('app.name') !!}
</x-mail::message>