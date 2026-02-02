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
            "Solutions Industry Focused - {$appName}",
            "Discover how {$appName} adapts to your industry needs. Restaurants, Retail, Services.",
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
            "About Us - {$appName}",
            "Learn about the team behind {$appName} and our mission to simplify business growth.",
            [['name' => 'About', 'url' => route('about')]]
        );

        return view('public.about', compact('seo'));
    }

    public function blog(): View
    {
        $appName = config('app.name');
        $seo = $this->getSeo(
            "Resources & Blog - {$appName}",
            'Expert advice, tips, and industry insights to grow your business.',
            [['name' => 'Blog', 'url' => route('blog.index')]]
        );

        // Mock posts
        $posts = [
            (object) ['slug' => 'boost-seo-2026', 'title' => 'How to Boost SEO in 2026', 'excerpt' => 'Strategies that work.'],
            (object) ['slug' => 'customer-retention', 'title' => 'Mastering Customer Retention', 'excerpt' => 'Keep them coming back.'],
        ];

        return view('public.blog.index', compact('seo', 'posts'));
    }

    public function post(string $slug): View
    {
        $appName = config('app.name');
        $seo = $this->getSeo(
            ucfirst(str_replace('-', ' ', $slug)) . " - {$appName} Blog",
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
        $appName = config('app.name');
        $seo = $this->getSeo(
            "Contact Us - {$appName}",
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

        $faqCategories = [
            [
                'name' => 'Simplicité et Fonctionnement',
                'icon' => 'wrench-screwdriver',
                'questions' => [
                    [
                        'question' => 'Mes clients doivent-ils télécharger une application ?',
                        'answer' => "Non. C'est la force d'InZeeCard. Vos clients utilisent les applications déjà présentes sur leur téléphone : Apple Wallet (iPhone) ou Google Pay (Android). Ils n'ont rien à installer, ce qui garantit un taux d'adoption maximal.",
                    ],
                    [
                        'question' => 'Comment le client récupère-t-il sa carte de fidélité ?',
                        'answer' => "C'est instantané. Le client scanne un QR Code sur votre comptoir ou approche son téléphone de votre sticker NFC InZeeCard. En deux clics, sa carte personnalisée est ajoutée à son portefeuille numérique.",
                    ],
                    [
                        'question' => 'Comment puis-je valider les points de mes clients ?',
                        'answer' => "Vous n'avez besoin d'aucun matériel spécifique. Vous utilisez simplement votre propre smartphone pour scanner la carte du client. Rapide, sans contact et sans erreur possible.",
                    ],
                ],
            ],
            [
                'name' => 'Valeur Business',
                'icon' => 'chart-bar',
                'questions' => [
                    [
                        'question' => 'Pourquoi passer du papier au digital avec InZeeCard ?',
                        'answer' => "Le papier se perd, s'oublie ou s'abîme. Avec InZeeCard, vous restez dans la poche de vos clients. Vous pouvez envoyer des notifications push (alertes gratuites) directement sur leur écran de verrouillage pour les informer d'une promotion ou d'un événement, boostant ainsi votre taux de retour.",
                    ],
                    [
                        'question' => 'Puis-je personnaliser le design de ma carte ?',
                        'answer' => 'Absolument. Vous pouvez intégrer votre logo, vos couleurs et définir vos propres règles de récompense (ex: "10€ offerts au 10ème passage" ou "-15% après 50€ d\'achats").',
                    ],
                ],
            ],
            [
                'name' => 'Prix et Engagement',
                'icon' => 'credit-card',
                'questions' => [
                    [
                        'question' => 'Y a-t-il des frais de mise en service ?',
                        'answer' => "Aucun. L'inscription et la configuration de votre compte sont gratuites. Vous ne payez que votre abonnement de 49€ HT / mois pour un usage illimité.",
                    ],
                    [
                        'question' => "L'offre est-elle avec engagement ?",
                        'answer' => "Non. Chez InZeeCard, nous croyons en la qualité de notre service. Votre abonnement est sans engagement : vous êtes libre de l'interrompre à tout moment depuis votre espace Stripe.",
                    ],
                ],
            ],
            [
                'name' => 'Sécurité et Données',
                'icon' => 'shield-check',
                'questions' => [
                    [
                        'question' => 'Qui possède les données de mes clients ?',
                        'answer' => "Vous. Contrairement à d'autres plateformes, les données collectées via InZeeCard vous appartiennent. Nous ne les revendons jamais. Vous construisez votre propre base de données pour votre marketing.",
                    ],
                    [
                        'question' => 'Le système est-il conforme au RGPD ?',
                        'answer' => "Oui. InZeeCard est conçu avec la protection des données par défaut. Le consentement du client est recueilli lors de l'ajout de la carte, et les données sont stockées de manière sécurisée en Europe.",
                    ],
                ],
            ],
        ];

        return view('public.faq', compact('seo', 'faqCategories'));
    }
}
