@extends('emails.layout')

@section('content')
    <h1>Abonnement Mis à jour</h1>

    <p>Bonjour,</p>

    <p>
        Nous vous confirmons que votre demande de changement d'offre pour l'équipe <strong>{{ $team->name }}</strong> vers
        le plan <strong>{{ $planName }}</strong> a bien été prise en compte.
    </p>

    <div class="panel">
        <div class="panel-content">
            <p>
                Vous pouvez dès à présent retrouver votre <strong>avoir</strong> et votre <strong>nouvelle facture</strong>
                directement dans votre espace de gestion.
            </p>
        </div>
    </div>

    <p>
        Merci de votre confiance.
    </p>

    <div style="text-align: center; margin-top: 32px;">
        <a href="{{ route('subscription.show', $team) }}" class="button" target="_blank" style="color: #ffffff !important;">
            Gérer mon abonnement
        </a>
    </div>
@endsection