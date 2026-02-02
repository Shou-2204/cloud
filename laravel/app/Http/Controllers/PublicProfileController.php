<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PublicProfileController extends Controller
{
    /**
     * Display the public organisation profile.
     */
    public function show(Request $request, Team $team)
    {
        if (! $team->subscribed()) {
            abort(403, 'This organization is not available publicly.');
        }

        // Basic Analytics: Count unique views per session
        $viewKey = 'viewed_team_'.$team->id;
        if (! Session::has($viewKey)) {
            $team->profile->increment('public_views');
            Session::put($viewKey, true);
        }

        // SEO Metadata
        $seo = [
            'title' => $team->name.' - Avis & Profil Public',
            'description' => $team->profile->tagline ?? $team->profile->bio ?? 'Découvrez les avis et services de '.$team->name,
            'image' => $team->profile->cover_image_path ? \Illuminate\Support\Facades\Storage::disk('cloud_public')->url($team->profile->cover_image_path) : null,
        ];

        return view('public.profile', [
            'team' => $team,
            'seo' => $seo,
        ]);
    }

    /**
     * Display the review gating form.
     */
    public function review(Request $request, Team $team)
    {
        if (! $team->subscribed()) {
            abort(403, 'This organization is not available publicly.');
        }

        if (! $team->settings->reviews_enabled) {
            return redirect()->route('profile.public', $team->public_uuid);
        }

        return view('public.review', [
            'team' => $team,
        ]);
    }
}
