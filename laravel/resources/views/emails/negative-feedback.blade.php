<x-mail::message>
    # 📣 Nouveau Retour Client

    Bonjour,

    Vous avez reçu un nouveau retour client via votre page d'avis ShouCloud.

    ---

    ## ⭐ Note attribuée

    @php
        $stars = str_repeat('⭐', $rating);
        $emptyStars = str_repeat('☆', 5 - $rating);
    @endphp

    **{{ $stars }}{{ $emptyStars }}** — {{ $rating }} / 5 étoiles

    ---

    ## 💬 Message du client

    <x-mail::panel>
        {{ $feedback }}
    </x-mail::panel>

    ---

    ## 💡 Pourquoi ce message ?

    > **Review Gating actif** : Les clients ayant donné une note de 1 à 3 étoiles sont redirigés vers ce formulaire
    privé plutôt que vers Google. Cela vous permet d'identifier et résoudre les problèmes avant qu'ils ne deviennent des
    avis publics négatifs.

    ---

    *Ce retour provient de votre page d'avis **{{ $team->name }}**.*

    Cordialement,<br>
    L'équipe {{ config('app.name') }}
</x-mail::message>