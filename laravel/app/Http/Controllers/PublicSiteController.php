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
        // Mapping simple for demo, in real app this could come from DB or config
        $solutions = [
            'restaurants' => [
                'title' => 'Solutions pour Restaurants & Cafés',
                'description' => 'Boostez le chiffre d\'affaires de votre restaurant grâce à la collecte automatisée d\'avis 5 étoiles et un programme de fidélité digital ultra-simple.',
                'features' => [
                    'Avis Google Automatisés' => 'Récupérez des avis positifs dès l\'encaissement.',
                    'Carte de Fidélité Digitalisée' => 'Fini les oublis, la carte est toujours dans le téléphone du client.',
                    'Marketing de Relance' => 'Envoyez des offres spéciales lors des jours de faible affluence.',
                ]
            ],
            'retail' => [
                'title' => 'Solutions pour Commerçants & Boutiques',
                'description' => 'Augmentez la fréquence de passage en magasin et transformez vos clients de passage en clients fidèles.',
                'features' => [
                    'Visibilité Locale Boostée' => 'Remontez dans les résultats de recherche Google Maps.',
                    'Base de Données Client' => 'Apprenez à mieux connaître vos clients et leurs habitudes.',
                    'Promotions Ciblées' => 'Informez instantanément vos clients de vos nouveautés.',
                ]
            ],
            'services' => [
                'title' => 'Solutions pour Entreprises de Services',
                'description' => 'Gérez votre réputation en ligne et fidélisez vos clients pour vos prestations récurrentes (Coiffeurs, Instituts, Artisans).',
                'features' => [
                    'Récupération de Feedback' => 'Identifiez les clients insatisfaits avant qu\'ils ne postent un avis négatif.',
                    'Simplicité d\'Usage' => 'Aucune installation technique requise pour vous ou vos clients.',
                    'Image de Marque Moderne' => 'Proposez une expérience digitale premium à vos clients.',
                ]
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

        // Mock posts
        $posts = [
            (object) [
                'slug' => 'boost-seo-2026',
                'title' => 'Comment Booster votre SEO Local en 2026',
                'excerpt' => 'Les stratégies indispensables pour dominer la recherche locale et attirer plus de clients.',
                'date' => '3 Février 2026',
                'content' => 'Le SEO local est devenu le pilier de la réussite pour tout commerce de proximité. En 2026, la clé ne réside plus seulement dans les mots-clés, mais dans la preuve sociale et l\'engagement. Apprenez comment optimiser votre fiche Google Business, pourquoi les avis clients sont votre meilleur atout et comment le mobile-first transforme l\'acquisition client.'
            ],
            (object) [
                'slug' => 'customer-retention',
                'title' => 'Maîtriser la Fidélisation Client au 21ème Siècle',
                'excerpt' => 'Pourquoi retenir un client coûte 5 fois moins cher que d\'en acquérir un nouveau.',
                'date' => '1 Février 2026',
                'content' => 'La fidélisation n\'est plus une option, c\'est une nécessité. Découvrez comment le passage aux cartes de fidélité digitales dans Apple Wallet & Google Wallet révolutionne la relation client. Nous explorons les mécanismes psychologiques de l\'engagement et comment de simples notifications push peuvent transformer votre chiffre d\'affaires sans dépenser un euro en publicité.'
            ],
        ];

        return view('public.blog.index', compact('seo', 'posts'));
    }
    public function post(string $slug): View
    {
        $posts = [
            'boost-seo-2026' => [
                'title' => 'Comment Booster votre SEO Local en 2026',
                'date' => '3 Février 2026',
                'content' => 'Le référencement local (SEO Local) est l\'outil le plus puissant pour un commerçant aujourd\'hui. Avec l\'évolution des algorithmes, Google privilégie désormais la fraîcheur des avis et l\'interaction réelle.

### Pourquoi le SEO Local est Vital ?
Chaque jour, des milliers de personnes cherchent des solutions autour d\'elles. Si vous n\'apparaissez pas dans le "Local Pack" de Google, vous n\'existez pas pour eux.

### Les 3 Piliers de 2026 :
1. **La Fraîcheur des Avis** : Google favorise les fiches qui reçoivent des avis réguliers plutôt que celles qui en ont beaucoup mais datant de l\'an dernier.
2. **L\'Engagement Mobile** : Votre site et votre tunnel de capture doivent être ultra-rapides sur smartphone.
3. **La Preuve Sociale Authentique** : Les avis détaillés avec des mots-clés naturels sont plus valorisés que les simples notes de 5 étoiles sans texte.

En automatisant la collecte d\'avis dès le passage en caisse, vous créez un flux naturel de contenu qui informe Google que votre établissement est actif et apprécié.'
            ],
            'customer-retention' => [
                'title' => 'Maîtriser la Fidélisation Client au 21ème Siècle',
                'date' => '1 Février 2026',
                'content' => 'Acquérir un nouveau client coûte de plus en plus cher. Dans ce contexte, la rétention (fidélisation) devient le levier de rentabilité numéro un.

### L\'Échec des Cartes Papier
Les clients perdent leurs cartes, les oublient, et cela crée une frustration plutôt qu\'un engagement. Le papier est "mort" pour la fidélisation moderne.

### Le Pouvoir du Mobile Wallet
En intégrant votre carte de fidélité directement dans l\'iPhone ou l\'Android de votre client via Apple Wallet & Google Pay, vous obtenez un avantage injuste :
- **Pas d\'oubli possible** : La carte est toujours là.
- **Notifications Push** : Vous pouvez envoyer des messages gratuits directement sur l\'écran verrouillé.
- **Données Actionnables** : Vous savez qui vient, quand et à quelle fréquence.

La fidélisation digitale permet de créer un lien direct et permanent, transformant un client de passage en un ambassadeur de votre marque.'
            ],
        ];

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
