<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class PublicLayout extends Component
{
    /**
     * SEO metadata for the page.
     *
     * @var array<string, string>
     */
    public array $seo;

    /**
     * Create a new component instance.
     */
    public function __construct(array $seo = [])
    {
        $this->seo = $seo;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.public', ['seo' => $this->seo]);
    }
}
