<?php

namespace App\Livewire;

use App\Mail\BugReportMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Livewire\Component;

class BugReport extends Component
{
    public bool $isOpen = false;
    public string $description = '';
    public bool $submitted = false;

    #[On('open-bug-modal')]
    public function openModal()
    {
        $this->isOpen = true;
        $this->description = '';
        $this->submitted = false;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->description = '';
        $this->submitted = false;
    }

    public function submit()
    {
        $this->validate([
            'description' => 'required|min:10|max:5000',
        ], [
            'description.required' => 'Veuillez décrire le bug.',
            'description.min' => 'La description doit contenir au moins 10 caractères.',
            'description.max' => 'La description ne peut pas dépasser 5000 caractères.',
        ]);

        $user = Auth::user();
        $currentUrl = request()->header('referer', url()->current());

        Mail::to(config('app.admin_notification_email'))
            ->send(new BugReportMail(
                user: $user,
                description: $this->description,
                reportedUrl: $currentUrl,
            ));

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.bug-report');
    }
}
