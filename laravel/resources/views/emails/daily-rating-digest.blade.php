@extends('emails.layout')

@section('content')
    <h1>Résumé Quotidien • {{ $teamName }}</h1>

    <p>Voici le bilan des avis reçus au cours des dernières 24 heures.</p>

    <!-- Stats Grid -->
    <table class="stats-grid" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td width="33%" style="padding-right: 8px;">
                <div class="stats-item">
                    <span class="stats-value">{{ number_format($averageRating, 1) }}/5</span>
                    <span class="stats-label">Moyenne</span>
                </div>
            </td>
            <td width="33%" style="padding: 0 4px;">
                <div class="stats-item">
                    <span class="stats-value text-green">{{ $positiveCount }}</span>
                    <span class="stats-label">Positifs</span>
                </div>
            </td>
            <td width="33%" style="padding-left: 8px;">
                <div class="stats-item">
                    <span class="stats-value text-red">{{ $negativeCount }}</span>
                    <span class="stats-label">Négatifs</span>
                </div>
            </td>
        </tr>
    </table>

    @if($negativeFeedbacks->isNotEmpty())
        <h2>💬 Retours à traiter</h2>
        <p>Vous avez reçu des commentaires nécessitant votre attention :</p>

        @foreach($negativeFeedbacks as $feedback)
            <div class="panel">
                <div class="panel-content">
                    <p>
                        <strong class="text-red">{{ $feedback->rating }}★/5</strong>
                        @if($feedback->created_at)
                            <span class="text-sm" style="color: #6b7280; margin-left: 8px;">
                                {{ $feedback->created_at->format('H:i') }}
                            </span>
                        @endif
                    </p>
                    <p style="margin-top: 8px; font-style: italic;">
                        "{{ $feedback->feedback }}"
                    </p>
                </div>
            </div>
        @endforeach
    @else
        @if($negativeCount > 0)
            <div class="panel">
                <div class="panel-content">
                    <p>Vous avez reçu {{ $negativeCount }} note(s) négative(s) sans commentaire écrit.</p>
                </div>
            </div>
        @else
            <div class="panel" style="background-color: #f0fdf4; border-left-color: #10b981;">
                <div class="panel-content">
                    <p class="text-green">Aucun retour négatif aujourd'hui. Bravo à toute l'équipe ! 👏</p>
                </div>
            </div>
        @endif
    @endif

    <div style="text-align: center; margin-top: 32px;">
        <a href="{{ route('dashboard') }}" class="button" target="_blank">
            Accéder au Dashboard
        </a>
    </div>
@endsection