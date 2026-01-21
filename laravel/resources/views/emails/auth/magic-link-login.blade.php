@extends('emails.layout')

@section('content')
    <h1>Connexion sans mot de passe</h1>

    <p>Bonjour,</p>

    <p>Vous avez demandé à vous connecter à <strong>{{ config('app.name') }}</strong> sans utiliser de mot de passe.</p>

    <p>Cliquez sur le bouton ci-dessous pour accéder directement à votre compte :</p>

    <div style="text-align: center; margin: 30px 0;">
        <a href="{{ $url }}" class="button" style="color: #ffffff !important;">Me connecter maintenant</a>
    </div>

    <p>Ce lien est valide pendant <strong>15 minutes</strong>. Si vous n'êtes pas à l'origine de cette demande, vous pouvez
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