@extends('emails.layout')

@section('content')
    <h1>🐛 Rapport de bug</h1>

    <p>Un utilisateur a signalé un bug sur <strong>{{ config('app.name') }}</strong>.</p>

    <div class="panel">
        <div class="panel-content">
            <p><strong>Utilisateur :</strong> {{ $user->name }} ({{ $user->email }})</p>
            <p><strong>Date :</strong> {{ $reportedAt->format('d/m/Y à H:i') }}</p>
            <p><strong>URL :</strong> <a href="{{ $reportedUrl }}"
                    style="color: #10b981; word-break: break-all;">{{ $reportedUrl }}</a></p>
        </div>
    </div>

    <h2>Description du bug</h2>

    <div style="background-color: #f3f4f6; padding: 16px; border-radius: 8px; margin: 16px 0;">
        <p style="white-space: pre-wrap; margin: 0;">{{ $description }}</p>
    </div>

    <p style="margin-top: 30px; font-size: 12px; color: #9ca3af;">
        Ce rapport a été envoyé automatiquement depuis l'application {{ config('app.name') }}.
    </p>
@endsection