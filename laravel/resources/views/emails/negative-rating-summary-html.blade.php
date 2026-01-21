<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Synthèse des avis négatifs - {{ $teamName }}</title>
</head>
<body style="background-color: #FFFBF5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #374151; margin: 0; padding: 0; width: 100% !important;">
    <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0" style="background-color: #FFFBF5; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" border="0" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="padding: 32px; text-align: center;">
                            <a href="{{ config('app.url') }}" style="color: #10b981; font-size: 19px; font-weight: bold; text-decoration: none;">
                                {{ config('app.name') }}
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 0 40px 40px 40px;">
                            <h1 style="color: #111827; font-size: 24px; font-weight: bold; margin: 0 0 24px 0; text-align: center;">
                                Synthèse des Avis Négatifs
                            </h1>
                            
                            <p style="text-align: center; margin-bottom: 32px; color: #6b7280;">
                                {{ $teamName }} • 
                                <span style="background-color: #FFFBF5; color: #10b981; padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500;">
                                    {{ match ($period) { '24h' => 'Dernières 24h', '7d' => '7 derniers jours', '30d' => '30 derniers jours', default => $period} }}
                                </span>
                            </p>

                            <p style="color: #4b5563; font-size: 16px; line-height: 1.6em; margin-bottom: 24px;">
                                Voici la liste des avis critiques (1-3 étoiles) reçus durant la période sélectionnée. Ces retours sont importants pour améliorer votre service.
                            </p>

                            <!-- Ratings List -->
                            @foreach($ratings as $rating)
                                <div style="border-left: 4px solid #ef4444; background-color: #fef2f2; padding: 16px; margin-bottom: 16px; border-radius: 0 4px 4px 0;">
                                    <div style="margin-bottom: 8px;">
                                        <strong style="color: #ef4444; font-size: 18px;">{{ $rating->rating }}/5</strong>
                                        <span style="color: #6b7280; font-size: 14px; margin-left: 8px;">
                                            {{ $rating->created_at->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                    @if($rating->feedback)
                                        <p style="color: #374151; margin: 0; font-style: italic;">
                                            "{{ $rating->feedback }}"
                                        </p>
                                    @else
                                        <p style="color: #9ca3af; margin: 0; font-style: italic;">
                                            Aucun commentaire écrit.
                                        </p>
                                    @endif
                                </div>
                            @endforeach

                            <!-- CTA -->
                            <div style="text-align: center; margin-top: 32px;">
                                <a href="{{ route('dashboard') }}" style="display: inline-block; background-color: #10b981; color: #ffffff; padding: 12px 24px; border-radius: 6px; text-decoration: none; font-weight: 600;">
                                    Accéder au tableau de bord
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 32px; text-align: center; background-color: #f9fafb;">
                            <p style="color: #9ca3af; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>