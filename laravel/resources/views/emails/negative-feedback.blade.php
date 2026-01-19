<x-mail::message>
    # Nouveau feedback client

    Un client vous a laissé un avis via votre page ShouCloud.

    ## Note attribuée

    @php
        $stars = str_repeat('⭐', $rating);
        $emptyStars = str_repeat('☆', 5 - $rating);
    @endphp

    <div style="font-size: 24px; margin: 20px 0;">
        {{ $stars }}{{ $emptyStars }} ({{ $rating }}/5)
    </div>

    ## Message du client

    <x-mail::panel>
        {{ $feedback }}
    </x-mail::panel>

    ---

    Ce message provient de votre page d'avis **{{ $team->name }}** sur ShouCloud.

    Les clients ayant donné une note de 1 à 3 étoiles sont redirigés vers ce formulaire privé au lieu de Google, vous
    permettant d'identifier et résoudre les problèmes en interne.

</x-mail::message>