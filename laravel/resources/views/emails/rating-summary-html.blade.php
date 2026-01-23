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
                                Synthèse des Avis
                            </h1>
                            
                            <p style="text-align: center; margin-bottom: 32px; color: #6b7280;">
                                {{ $teamName }} • 
                                <span style="background-color: #FFFBF5; color: #10b981; padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: 500;">
                                    {{ match ($period) { '24h' => 'Dernières 24h', '7d' => '7 derniers jours', '30d' => '30 derniers jours', default => $period} }}
                                </span>
                                    {{ match ($period) { '24h' => 'Dernières 24h', '7d' => '7 derniers jours', '30d' => '30 derniers jours', default => $period} }}
                                </span>
                            </p>

                            <!-- Stats Summary -->
                            <div style="text-align: center; margin-bottom: 32px; padding: 20px; background-color: #f9fafb; border-radius: 8px;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="50%" style="text-align: center; border-right: 1px solid #e5e7eb;">
                                            <div style="font-size: 24px; font-weight: bold; color: #111827;">{{ $ratings->count() }}</div>
                                            <div style="font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 4px;">Avis reçus</div>
                                        </td>
                                        <td width="50%" style="text-align: center;">
                                            <div style="font-size: 24px; font-weight: bold; color: #10b981;">{{ number_format($ratings->avg('rating'), 1) }}/5</div>
                                            <div style="font-size: 14px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-top: 4px;">Moyenne</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <p style="color: #4b5563; font-size: 16px; line-height: 1.6em; margin-bottom: 24px;">
                                Voici la liste des avis et retours clients reçus durant la période sélectionnée.
                            </p>

                            <!-- Ratings List -->
                            @foreach($ratings as $rating)
                                @php
                                    $isPositive = $rating->rating >= 4;
                                    $borderColor = $isPositive ? '#10b981' : '#ef4444';
                                    $bgColor = $isPositive ? '#f0fdf4' : '#fef2f2';
                                    $textColor = $isPositive ? '#10b981' : '#ef4444';
                                @endphp
                                <div style="border-left: 4px solid {{ $borderColor }}; background-color: {{ $bgColor }}; padding: 16px; margin-bottom: 16px; border-radius: 0 4px 4px 0;">
                                    <div style="margin-bottom: 8px;">
                                        <strong style="color: {{ $textColor }}; font-size: 18px;">{{ $rating->rating }}/5</strong>
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