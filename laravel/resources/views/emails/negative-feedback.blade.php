@extends('emails.layout')

@section('content')
    <h1>Nouveau Retour Client</h1>

    <p>Vous avez reçu un nouveau retour client via votre page d'avis <strong>{{ $team->name }}</strong>.</p>

    <div style="text-align: center; margin: 32px 0;">
        @php
            $stars = str_repeat('⭐', $rating);
            $emptyStars = str_repeat('☆', 5 - $rating);
        @endphp
        <div style="font-size: 32px; letter-spacing: 5px; margin-bottom: 12px;">
            {!! $stars !!}<span style="color: #d1d5db;">{{ $emptyStars }}</span>
        </div>
        <div style="font-size: 18px; font-weight: bold; color: #111827;">
            {{ $rating }} / 5 étoiles
        </div>
    </div>

    <h2>Message du client</h2>

    <div class="panel">
        <div class="panel-content">
            <p style="font-style: italic; color: #111827;">"{{ $feedback }}"</p>
        </div>
    </div>

    <div style="background-color: #f9fafb; padding: 16px; border-radius: 8px; margin-top: 32px; border: 1px solid #e5e7eb;">
        <p style="margin: 0; font-size: 14px; color: #6b7280;">
            <strong style="color: #10b981;">💡 Pourquoi ce message ?</strong><br>
            Le système de <em>Review Gating</em> est actif. Les clients insatisfaits (1-3 étoiles) sont redirigés vers ce
            formulaire interne au lieu de Google. Cela vous donne l'opportunité de traiter le problème en privé.
        </p>
    </div>

    <div style="text-align: center; margin-top: 32px;">
        <a href="{{ route('dashboard') }}" class="button" target="_blank">
            Accéder au Dashboard
        </a>
    </div>
@endsection