<?php

namespace App\Livewire;

use App\Services\SlackNotificationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class BugReport extends Component
{
    protected SlackNotificationService $slack;

    public function boot(SlackNotificationService $slack)
    {
        $this->slack = $slack;
    }

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



        $this->slack->notifyBug(
            "🐛 Nouveau Rapport de Bug !\n\n👤 *Utilisateur:* {$user->name} ({$user->email})\n🔗 *URL:* {$currentUrl}\n📝 *Description:*\n{$this->description}"
        );

        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.bug-report');
    }
}
