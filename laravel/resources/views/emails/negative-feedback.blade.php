<x-mail::message>
# Nouveau Retour Client

Bonjour,

Vous avez reçu un nouveau retour client via votre page d'avis **{!! $team->name !!}**.

---

<div style="text-align: center; margin: 25px 0;">
    @php
        $stars = str_repeat('⭐', $rating);
        $emptyStars = str_repeat('☆', 5 - $rating);
    @endphp
    <div style="font-size: 32px; letter-spacing: 5px; margin-bottom: 10px;">
        {!! $stars !!}<span style="color: #ccc;">{!! $emptyStars !!}</span>
    </div>
    <div style="font-size: 18px; font-weight: bold; color: #555;">
        {{ $rating }} / 5 étoiles
    </div>
</div>

---

## Message du client

<x-mail::panel>
"{!! $feedback !!}"
</x-mail::panel>

---

<div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; font-size: 14px; color: #666;">
    <strong>💡 Pourquoi ce message ?</strong><br>
    Le système de <em>Review Gating</em> est actif. Les clients insatisfaits (1-3 étoiles) sont redirigés ici au lieu de Google, vous donnant une chance de corriger le tir en privé.
</div>

---

Cordialement,<br>
L'équipe {!! config('app.name') !!}
</x-mail::message>