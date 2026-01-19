<x-mail::message>
    # 📣 Nouveau Retour Client

    Bonjour,

    Vous avez reçu un nouveau retour client via votre page d'avis ShouCloud.

    ## Note attribuée

    @php
        $stars = str_repeat('⭐', $rating);
        $emptyStars = str_repeat('☆', 5 - $rating);
        $ratingColor = match (true) {
            $rating <= 2 => '#dc2626',
            $rating == 3 => '#f59e0b',
            default => '#10b981'
        };
    @endphp

    <div
        style="text-align: center; padding: 20px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 12px; margin: 16px 0;">
        <div style="font-size: 32px; margin-bottom: 8px;">
            {{ $stars }}{{ $emptyStars }}
        </div>
        <div style="font-size: 24px; font-weight: bold; color: {{ $ratingColor }};">
            {{ $rating }} / 5 étoiles
        </div>
    </div>

    ## Message du client

    <x-mail::panel>
        <div style="font-style: italic; color: #374151; line-height: 1.6;">
            "{{ $feedback }}"
        </div>
    </x-mail::panel>

    ## Pourquoi ce message ?

    <div
        style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px 16px; border-radius: 4px; margin: 16px 0;">
        💡 <strong>Review Gating actif</strong><br>
        Les clients ayant donné une note de 1 à 3 étoiles sont redirigés vers ce formulaire privé plutôt que vers
        Google. Cela vous permet d'identifier et résoudre les problèmes avant qu'ils ne deviennent des avis publics
        négatifs.
    </div>

    ---

    *Ce retour provient de votre page d'avis **{{ $team->name }}**.*

    Cordialement,<br>
    L'équipe {{ config('app.name') }}
</x-mail::message>