<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Synthèse des avis négatifs - {{ $teamName }}</title>
</head>

<body
    style="background-color: #f3f4f6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; -webkit-text-size-adjust: none; color: #1f2937; margin: 0; padding: 0; width: 100% !important;">
    <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0"
        style="background-color: #f3f4f6; padding: 20px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" border="0" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background-color: #ffffff; padding: 32px 40px; text-align: center; border-bottom: 3px solid #ef4444;">
                            <h1 style="color: #111827; font-size: 24px; font-weight: 700; margin: 0;">Synthèse des Avis
                                Négatifs</h1>
                            <p style="color: #6b7280; font-size: 16px; margin: 8px 0 0 0;">{{ $teamName }}</p>
                            <div
                                style="display: inline-block; margin-top: 12px; padding: 6px 16px; background-color: #fef2f2; border-radius: 9999px; color: #ef4444; font-size: 14px; font-weight: 600;">
                                Période :
                                {{ match ($period) { '24h' => 'Dernières 24h', '7d' => '7 derniers jours', '30d' => '30 derniers jours', default => $period} }}
                            </div>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 32px 40px;">
                            <p style="color: #374151; font-size: 16px; line-height: 24px; margin-bottom: 24px;">
                                Bonjour,
                            </p>
                            <p style="color: #374151; font-size: 16px; line-height: 24px; margin-bottom: 32px;">
                                Voici la liste des avis critiques (1-3 étoiles) reçus durant la période sélectionnée.
                                Ces retours sont importants pour améliorer votre service.
                            </p>

                            <!-- Ratings List -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0">
                                @foreach($ratings as $rating)
                                    <tr>
                                        <td
                                            style="padding: 20px; background-color: #f9fafb; border-radius: 8px; margin-bottom: 16px; display: block; border: 1px solid #e5e7eb;">
                                            <table role="presentation" width="100%" border="0" cellpadding="0"
                                                cellspacing="0">
                                                <tr>
                                                    <td style="padding-bottom: 12px;">
                                                        <!-- Stats Row -->
                                                        <table role="presentation" width="100%" border="0" cellpadding="0"
                                                            cellspacing="0">
                                                            <tr>
                                                                <td
                                                                    style="font-size: 20px; font-weight: bold; color: #ef4444;">
                                                                    {{ $rating->rating }}/5 <span
                                                                        style="font-size: 16px;">⭐</span>
                                                                </td>
                                                                <td align="right" style="color: #6b7280; font-size: 14px;">
                                                                    {{ $rating->created_at->format('d/m/Y H:i') }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                @if($rating->feedback)
                                                    <tr>
                                                        <td style="border-top: 1px solid #e5e7eb; padding-top: 12px;">
                                                            <p
                                                                style="color: #1f2937; font-size: 15px; line-height: 22px; margin: 0; font-style: italic;">
                                                                "{{ $rating->feedback }}"
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td style="border-top: 1px solid #e5e7eb; padding-top: 12px;">
                                                            <p
                                                                style="color: #9ca3af; font-size: 14px; margin: 0; font-style: italic;">
                                                                Aucun commentaire écrit.
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="16" style="font-size: 16px; line-height: 16px;">&nbsp;</td>
                                    </tr> <!-- Spacer -->
                                @endforeach
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" width="100%" border="0" cellpadding="0" cellspacing="0"
                                style="margin-top: 16px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('dashboard') }}"
                                            style="display: inline-block; background-color: #111827; color: #ffffff; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 16px;">
                                            Accéder au tableau de bord
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f9fafb; padding: 24px 40px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #9ca3af; font-size: 14px; margin: 0;">
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