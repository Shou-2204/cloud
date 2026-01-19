<x-mail::message>
    # 🔔 Demande de désabonnement

    Bonjour,

    Une demande de désabonnement vient d'être effectuée sur ShouCloud.

    ---

    ## 🏢 Informations de l'organisation

    | | |
    |:--|:--|
    | **Nom** | {{ $team->name }} |
    | **Email** | {{ $userEmail }} |
    | **Utilisateur** | {{ $userName }} |

    ---

    ## 📋 Raison du départ

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
        {{ $reasonLabel }}
    </x-mail::panel>

    ---

    ## 📞 Contact autorisé

    @if($contactAllowed)
        ✅ **Oui**, l'utilisateur accepte d'être recontacté pour en discuter.

        <x-mail::button :url="'mailto:' . $userEmail . '?subject=Retour sur votre désabonnement ShouCloud'" color="primary">
            Contacter {{ $userName }}
        </x-mail::button>
    @else
        ❌ **Non**, l'utilisateur ne souhaite pas être recontacté.
    @endif

    ---

    *Cet email a été envoyé automatiquement par ShouCloud suite à une demande de désabonnement.*

    Cordialement,<br>
    L'équipe {{ config('app.name') }}
</x-mail::message>