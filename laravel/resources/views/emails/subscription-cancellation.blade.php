<x-mail::message>
    # Nouveau désabonnement

    Une organisation vient de se désabonner de ShouCloud.

    ## Détails

    | Information | Valeur |
    |:------------|:-------|
    | **Organisation** | {{ $team->name }} |
    | **Email utilisateur** | {{ $userEmail }} |
    | **Nom utilisateur** | {{ $userName }} |
    | **Raison** |
    {{ match ($reason) { 'too_expensive' => 'Trop cher', 'missing_features' => 'Fonctionnalités manquantes', 'bugs' => 'Trop de bugs', 'other' => 'Autre', default => $reason} }}
    |
    | **Peut-on le recontacter ?** | {{ $contactAllowed ? '✅ Oui' : '❌ Non' }} |

    @if($contactAllowed)
        <x-mail::button :url="'mailto:' . $userEmail">
            Contacter l'utilisateur
        </x-mail::button>
    @endif

    ---

    *Email automatique envoyé par ShouCloud.*

</x-mail::message>