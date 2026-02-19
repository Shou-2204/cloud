<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

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
        $appName = config('app.name');
        $seo = $this->getSeo(
            "Solutions Métiers - {$appName}",
            "Découvrez comment {$appName} s'adapte à votre secteur d'activité : Restaurants, Commerces, Services.",
            [['name' => 'Solutions', 'url' => route('solutions.index')]]
        );

        return view('public.solutions.index', compact('seo'));
    }

    public function solution(string $slug): View
    {
        $solutions = config('marketing.solutions', []);

        abort_if(!isset($solutions[$slug]), 404);

        $appName = config('app.name');
        $data = $solutions[$slug];
        $seo = $this->getSeo(
            $data['title'] . " - {$appName}",
            $data['description'],
            [
                ['name' => 'Solutions', 'url' => route('solutions.index')],
                ['name' => ucfirst($slug), 'url' => route('solutions.show', $slug)],
            ]
        );

        return view('public.solutions.show', compact('seo', 'slug', 'data'));
    }

    public function features(): View
    {
        $appName = config('app.name');
        $seo = $this->getSeo(
            "Fonctionnalités - {$appName}",
            "Découvrez l'ensemble des fonctionnalités de {$appName} : Avis Google, Wallet, Marketing SMS & Email.",
            [['name' => 'Fonctionnalités', 'url' => route('features')]]
        );

        return view('public.features', compact('seo'));
    }

    public function about(): View
    {
        $appName = config('app.name');
        $seo = $this->getSeo(
            "À propos - {$appName}",
            "Découvrez l'équipe derrière {$appName} et notre mission pour simplifier la croissance des commerçants.",
            [['name' => 'À propos', 'url' => route('about')]]
        );

        return view('public.about', compact('seo'));
    }

    public function blog(): View
    {
        $appName = config('app.name');
        $seo = $this->getSeo(
            "Ressources & Blog - {$appName}",
            'Conseils d\'experts, astuces et actualités pour développer votre commerce.',
            [['name' => 'Blog', 'url' => route('blog.index')]]
        );

        // Load posts from config and cast to objects for view
        $postsData = config('marketing.blog_posts', []);
        $posts = [];
        foreach ($postsData as $slug => $data) {
            $data['slug'] = $slug;
            $posts[] = (object) $data;
        }

        return view('public.blog.index', compact('seo', 'posts'));
    }
    public function post(string $slug): View
    {
        $posts = config('marketing.blog_posts', []);

        abort_if(!isset($posts[$slug]), 404);

        $data = $posts[$slug];
        $appName = config('app.name');
        $seo = $this->getSeo(
            $data['title'] . " - {$appName} Blog",
            'Découvrez nos conseils d\'experts pour développer votre commerce.',
            [
                ['name' => 'Blog', 'url' => route('blog.index')],
                ['name' => $data['title'], 'url' => route('blog.show', $slug)],
            ]
        );

        return view('public.blog.show', compact('seo', 'slug', 'data'));
    }

    public function contact(): View
    {
        $appName = config('app.name');
        $seo = $this->getSeo(
            "Contactez-nous - {$appName}",
            'Une question ? Notre équipe est là pour vous aider.',
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

        $appName = config('app.name');
        $seo = $this->getSeo(
            $titles[$page] . " - {$appName}",
            'Read our ' . strtolower($titles[$page]),
            [['name' => 'Legal', 'url' => '#'], ['name' => $titles[$page], 'url' => route('legal.show', $page)]]
        );

        return view('public.legal.show', compact('seo', 'page'));
    }

    public function faq(): View
    {
        $appName = config('app.name');
        $seo = $this->getSeo(
            "FAQ - Questions Fréquentes - {$appName}",
            "Trouvez les réponses à vos questions sur {$appName} : fonctionnement, prix, sécurité des données et plus encore.",
            [['name' => 'FAQ', 'url' => route('faq')]]
        );

        $faqCategories = config('marketing.faq', []);

        return view('public.faq', compact('seo', 'faqCategories'));
    }
}
