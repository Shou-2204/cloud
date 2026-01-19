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
        if (!$team->subscribed()) {
            abort(403, 'This organization is not available publicly.');
        }

        // Basic Analytics: Count unique views per session
        $viewKey = 'viewed_team_' . $team->id;
        if (!Session::has($viewKey)) {
            $team->increment('public_views');
            Session::put($viewKey, true);
        }

        return view('public.profile', [
            'team' => $team,
        ]);
    }

    /**
     * Display the review gating form.
     */
    public function review(Request $request, Team $team)
    {
        if (!$team->subscribed()) {
            abort(403, 'This organization is not available publicly.');
        }

        if (!$team->reviews_enabled) {
            return redirect()->route('profile.public', $team->public_uuid);
        }

        return view('public.review', [
            'team' => $team,
        ]);
    }
}
