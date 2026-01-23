<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Auth\MagicLinkLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class MagicLinkController extends Controller
{
    /**
     * Send the magic link to the user.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $user = User::where('email', $data['email'])->firstOrFail();

        // Generate Relative Signed URL (signature valid for path only)
        // This prevents host/scheme mismatches (http vs https, localhost vs 127.0.0.1)
        $relativePath = URL::temporarySignedRoute(
            'login.magic-link.verify',
            now()->addMinutes(15),
            ['user' => $user->id],
            absolute: false
        );

        // Construct full URL manually using APP_URL
        $url = rtrim(config('app.url'), '/').$relativePath;

        // Send Email
        Mail::to($user)->send(new MagicLinkLogin($url));

        return back()->with('status', 'Un lien de connexion magique a été envoyé à votre adresse email !');
    }

    /**
     * Verify the magic link and log the user in.
     */
    public function verify(Request $request, User $user)
    {
        // Use relative signature check (absolute: false) to prevent issues with
        // http/https or localhost/127.0.0.1 mismatches in local environments.
        if (! $request->hasValidSignature(absolute: false)) {
            abort(401, 'Ce lien de connexion a expiré ou est invalide.');
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
