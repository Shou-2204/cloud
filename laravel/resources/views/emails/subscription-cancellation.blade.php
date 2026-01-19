<x-mail::message>
# Demande de désabonnement

Bonjour,

Une demande de désabonnement vient d'être effectuée pour l'organisation **{!! $team->name !!}**.

---

## Informations

**Organisation** : {!! $team->name !!}
<br>
**Utilisateur** : {!! $userName !!}
<br>
**Email** : {!! $userEmail !!}

---

## Raison du départ

@php
$reasonLabel = match ($reason) {
    'too_expensive' => '💰 Le service est trop cher',
    'missing_features' => '🔧 Fonctionnalités manquantes',
    'bugs' => '🐛 Trop de problèmes techniques',
    'other' => '📝 Autre raison',
    default => $reason
};
@endphp

**{!! $reasonLabel !!}**

---

## Contact

@if($contactAllowed)
✅ **L'utilisateur souhaite être recontacté.**

<x-mail::button :url="'mailto:' . $userEmail . '?subject=Retour sur votre désabonnement'">
Contacter {!! $userName !!}
</x-mail::button>
@else
❌ **L'utilisateur ne souhaite pas être recontacté.**
@endif

---

Cordialement,<br>
L'équipe {!! config('app.name') !!}
</x-mail::message>