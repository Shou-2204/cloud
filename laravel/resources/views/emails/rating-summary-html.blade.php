@extends('emails.layout')

@section('content')
    <h1>Synthèse des Avis • {{ $teamName }}</h1>

    <p style="text-align: center; margin-bottom: 24px;">
        <span
            style="background-color: #FFFBF5; color: #10b981; padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500;">
            {{ match ($period) { '24h' => 'Dernières 24h', '7d' => '7 derniers jours', '30d' => '30 derniers jours', default => $period} }}
        </span>
    </p>

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

    @if($feedbacks->isNotEmpty())
        <h2>💬 Détail des avis</h2>
        <p>Voici les messages laissés par vos clients :</p>

        @foreach($feedbacks as $feedback)
            <div class="panel" style="{{ $feedback->rating >= 4 ? 'border-left-color: #10b981;' : 'border-left-color: #ef4444;' }}">
                <div class="panel-content">
                    <p>
                        <strong class="{{ $feedback->rating >= 4 ? 'text-green' : 'text-red' }}">{{ $feedback->rating }}★/5</strong>
                        @if($feedback->created_at)
                            <span class="text-sm" style="color: #6b7280; margin-left: 8px;">
                                {{ $feedback->created_at->format('d/m/Y H:i') }}
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
        <div class="panel" style="background-color: #f9fafb; border-left-color: #9ca3af;">
            <div class="panel-content">
                <p>Vous avez reçu des notes sans commentaire écrit durant cette période.</p>
            </div>
        </div>
    @endif

    <div style="text-align: center; margin-top: 32px;">
        <a href="{{ route('dashboard') }}" class="button" target="_blank">
            Accéder au Dashboard
        </a>
    </div>
@endsection