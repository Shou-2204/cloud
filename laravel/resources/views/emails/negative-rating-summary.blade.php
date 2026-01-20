@component('mail::message')
# Synthèse des avis négatifs

Voici le récapitulatif des avis négatifs reçus pour **{{ $teamName }}** sur la période : **{{ match ($period) {
    '24h' => 'dernières 24 heures',
    '7d' => '7 derniers jours',
    '30d' => '30 derniers jours',
    default => 'période sélectionnée',
} }}**.

---

## {{ $ratings->count() }} avis négatif(s) à traiter

@foreach($ratings as $rating)
    ### {{ $rating->rating }} ⭐ — {{ $rating->created_at->format('d/m/Y à H:i') }}

    @if($rating->feedback)
        > {{ $rating->feedback }}
    @else
        _Aucun commentaire laissé_
    @endif

    ---

@endforeach

Cordialement,<br>
{{ config('app.name') }}
@endcomponent