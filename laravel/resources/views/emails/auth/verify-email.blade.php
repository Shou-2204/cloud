@extends('emails.layout')

@section('content')
    <h1>Confirmez votre adresse email</h1>

    <p>Bonjour,</p>

    <p>Merci de vous être inscrit sur <strong>{{ config('app.name') }}</strong> !</p>

    <p>Cliquez sur le bouton ci-dessous pour confirmer votre adresse email et activer votre compte :</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $url }}" class="button" style="color: #ffffff !important;">Confirmer mon email</a>
    </div>

    <p>Ce lien est valide pendant <strong>60 minutes</strong>. Si vous n'êtes pas à l'origine de cette inscription, vous
        pouvez
        ignorer cet email en toute sécurité.</p>

    <p style="margin-top: 30px;">
        Merci,<br>
        L'équipe {{ config('app.name') }}
    </p>

    <div style="margin-top: 20px; font-size: 12px; color: #9ca3af;">
        Si le bouton ne fonctionne pas, copiez et collez ce lien dans votre navigateur :<br>
        <a href="{{ $url }}" style="color: #10b981; word-break: break-all;">{{ $url }}</a>
    </div>
@endsection