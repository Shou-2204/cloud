<?php

namespace App\Livewire;

use App\Models\Lead;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class Unsubscribe extends Component
{
    #[Rule('required|email')]
    public string $email = '';

    public bool $unsubscribed = false;

    public function unsubscribe()
    {
        $this->ensureRequestIsNotRateLimited();

        $this->validate();

        $lead = Lead::where('email', $this->email)->first();

        if ($lead) {
            $lead->update(['newsletter_subscribed' => false]);
        }

        // We show success even if the email wasn't found to prevent email enumeration,
        // or we could show a specific message. For now, let's just say it's done. 
        // But the plan said "Update Lead where email matches".
        
        $this->unsubscribed = true;
        
        RateLimiter::hit($this->throttleKey());
    }

    protected function ensureRequestIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey()
    {
        return 'unsubscribe:' . request()->ip() . '|' . session()->getId();
    }

    #[Layout('layouts.guest')] 
    public function render()
    {
        return view('livewire.unsubscribe');
    }
}
