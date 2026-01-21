@extends('emails.layout')

@section('content')
<h1>Synthèse des avis négatifs</h1>

<p>
    Voici le récapitulatif des avis négatifs reçus pour <strong>{{ $teamName }}</strong> sur la période : 
    <span style="color: #10b981; font-weight: 500;">
        {{ match ($period) {
            '24h' => 'dernières 24 heures',
            '7d' => '7 derniers jours',
            '30d' => '30 derniers jours',
            default => 'période sélectionnée',
        } }}
    </span>.
</p>

<h2>{{ $ratings->count() }} avis négatif(s) à traiter</h2>

@foreach($ratings as $rating)
    <div class="panel" style="border-left-color: #ef4444; background-color: #fef2f2;">
        <div class="panel-content">
            <div style="margin-bottom: 8px;">
                <strong style="color: #ef4444; font-size: 18px;">{{ $rating->rating }}/5</strong>
                <span style="color: #6b7280; font-size: 14px; margin-left: 8px;">
                    {{ $rating->created_at->format('d/m/Y à H:i') }}
                </span>
            </div>
            @if($rating->feedback)
                <p style="font-style: italic; color: #374151;">"{{ $rating->feedback }}"</p>
            @else
                <p style="font-style: italic; color: #9ca3af;">Aucun commentaire écrit.</p>
            @endif
        </div>
    </div>
@endforeach

<div style="text-align: center; margin-top: 32px;">
    <a href="{{ route('dashboard') }}" class="button" target="_blank">
        Accéder au Dashboard
    </a>
</div>
@endsection