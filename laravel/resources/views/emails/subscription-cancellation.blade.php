<x-mail::message>
# 🔔     Demande de désabonnement

Bonj    our,

Une     demande de désabonnement vient d'être effectuée pour l'organisation **{{ $team->name }}**.

---    

## *    *📋 Informations**

| |     |
|:--    -|:---|
| **    Organisation** | {{ $team->name }} |
| **    Utilisateur** | {{ $userName }} |
| **    Email** | {{ $userEmail }} |

---    

## *    *� Raison du départ**

@php    
$reasonL    abel = match ($reason) {
    'too_exp    ensive' => '💰 Le service est trop cher',
    'missing    _features' => '🔧 Fonctionnalités manquantes',
    'bugs' =    > '🐛 Trop de problèmes techniques',
    'other'     => '📝 Autre raison',
    default     => $reason
};    
@end    php

> **    {{ $reasonLabel }}**

---    

## *    *📞 Contact**

@if(    $contactAllowed)
    
    
<x-mail::button :url="'mailto:' . $userEmail . '?subject=Retour sur votre désabonnement ShouCloud'">
Contacter {{ $userName }}
</x-mail::button>
@else
❌ **L'utilisateur ne souhaite pas être recontacté.**
@endif
    
---    

Cord    ialement,<br>
    
    mail::message>