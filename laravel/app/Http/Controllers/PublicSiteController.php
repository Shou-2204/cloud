<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PublicSiteController extends Controller
{
    private function getSeo(string $title, string $description, array $breadcrumbs = []): array
    {
        return [
            'title' => $title,
            'description' => $description,
            'breadcrumbs' => $breadcrumbs,
        ];
    }

    public function solutions(): View
    {
        $seo = $this->getSeo(
            'Solutions Industry Focused - ShouCloud',
            'Discover how ShouCloud adapts to your industry needs. Restaurants, Retail, Services.',
            [['name' => 'Solutions', 'url' => route('solutions.index')]]
        );
        return view('public.solutions.index', compact('seo'));
    }

    public function solution(string $slug): View
    {
        // Mapping simple for demo, in real app this could come from DB or config
        $solutions = [
            'restaurants' => [
                'title' => 'Customer Reviews & Loyalty for Restaurants',
                'description' => 'Boost your restaurant revenue with automated reviews and sticky loyalty programs.',
            ],
            'retail' => [
                'title' => 'Retail Growth Solutions',
                'description' => 'Drive foot traffic and repeat purchases for your retail store.',
            ],
            'services' => [
                'title' => 'Service Business Tools',
                'description' => 'Streamline your service business bookings and client retention.',
            ],
        ];

        abort_if(!isset($solutions[$slug]), 404);

        $data = $solutions[$slug];
        $seo = $this->getSeo(
            $data['title'] . ' - ShouCloud',
            $data['description'],
            [
                ['name' => 'Solutions', 'url' => route('solutions.index')],
                ['name' => ucfirst($slug), 'url' => route('solutions.show', $slug)],
            ]
        );

        return view('public.solutions.show', compact('seo', 'slug', 'data'));
    }

    public function about(): View
    {
        $seo = $this->getSeo(
            'About Us - ShouCloud',
            'Learn about the team behind ShouCloud and our mission to simplify business growth.',
            [['name' => 'About', 'url' => route('about')]]
        );
        return view('public.about', compact('seo'));
    }

    public function blog(): View
    {
        $seo = $this->getSeo(
            'Resources & Blog - ShouCloud',
            'Expert advice, tips, and industry insights to grow your business.',
            [['name' => 'Blog', 'url' => route('blog.index')]]
        );

        // Mock posts
        $posts = [
            (object) ['slug' => 'boost-seo-2026', 'title' => 'How to Boost SEO in 2026', 'excerpt' => 'Strategies that work.'],
            (object) ['slug' => 'customer-retention', 'title' => 'Mastering Customer Retention', 'excerpt' => 'Keep them coming back.']
        ];

        return view('public.blog.index', compact('seo', 'posts'));
    }

    public function post(string $slug): View
    {
        $seo = $this->getSeo(
            ucfirst(str_replace('-', ' ', $slug)) . ' - ShouCloud Blog',
            'Read our comprehensive guide on this topic.',
            [
                ['name' => 'Blog', 'url' => route('blog.index')],
                ['name' => ucfirst(str_replace('-', ' ', $slug)), 'url' => route('blog.show', $slug)],
            ]
        );

        return view('public.blog.show', compact('seo', 'slug'));
    }

    public function contact(): View
    {
        $seo = $this->getSeo(
            'Contact Us - ShouCloud',
            'Get in touch with our support or sales team.',
            [['name' => 'Contact', 'url' => route('contact')]]
        );
        return view('public.contact', compact('seo'));
    }

    public function legal(string $page): View
    {
        $validPages = ['terms', 'privacy'];
        abort_if(!in_array($page, $validPages), 404);

        $titles = [
            'terms' => 'Terms of Service',
            'privacy' => 'Privacy Policy',
        ];

        $seo = $this->getSeo(
            $titles[$page] . ' - ShouCloud',
            'Read our ' . strtolower($titles[$page]),
            [['name' => 'Legal', 'url' => '#'], ['name' => $titles[$page], 'url' => route('legal.show', $page)]]
        );

        return view('public.legal.show', compact('seo', 'page'));
    }
}
