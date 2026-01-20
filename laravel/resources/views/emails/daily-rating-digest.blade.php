@component('mail::message')
# Résumé des avis du jour

Bonjour,

Voici le récapitulatif des avis reçus pour **{{ $teamName }}** :

---

## 📈 Statistiques

@component('mail::table')
| Métrique | Valeur |
|:---------|:-------|
| **Total des avis** | {{ $ratings->count() }} |
| **Note moyenne** | {{ number_format($averageRating, 1) }} / 5 ⭐ |
| **Avis positifs (4-5★)** | {{ $positiveCount }} |
| **Avis négatifs (1-3★)** | {{ $negativeCount }} |
@endcomponent

---

@if($negativeFeedbacks->isNotEmpty())
    ## ⚠️ Retours négatifs à traiter

    @foreach($negativeFeedbacks as $feedback)
        ### {{ $feedback->rating }} ⭐ - {{ $feedback->created_at->format('d/m/Y H:i') }}

        > {{ $feedback->feedback }}

        ---

    @endforeach
@else
    ## ✅ Aucun retour négatif

    Félicitations ! Aucun avis négatif n'a été reçu.
@endif

Merci,<br>
{{ config('app.name') }}
@endcomponent