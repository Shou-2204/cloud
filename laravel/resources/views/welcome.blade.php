<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ShouCloud - Marketing Digital pour Commerçants</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Animations */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 1s cubic-bezier(0.16, 1, 0.3, 1), transform 1s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .reveal-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .delay-100 {
            transition-delay: 100ms;
        }

        .delay-200 {
            transition-delay: 200ms;
        }

        .delay-300 {
            transition-delay: 300ms;
        }

        /* Smooth hover for cards */
        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px) scale(1.01);
            box-shadow: 0 10px 30px -10px rgba(16, 185, 129, 0.2);
        }
    </style>
</head>

<body
    class="antialiased bg-gray-50 text-gray-900 font-sans selection:bg-emerald-500 selection:text-white overflow-x-hidden">

    <!-- Navigation -->
    @livewire('navigation-menu')

    <!-- MAIN CONTENT WRAPPER (Full Height) -->
    <main class="min-h-screen flex flex-col pt-24 pb-10 sm:pt-28">

        <div class="flex-grow max-w-7xl mx-auto px-6 w-full flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

            <!-- LEFT COLUMN: HERO TEXT -->
            <div class="flex-1 text-center lg:text-left z-10">
                <h1
                    class="reveal-on-scroll text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-[1.1] mb-6">
                    Attirez et fidélisez <br /> <span class="text-emerald-600">simplement.</span>
                </h1>

                <p
                    class="reveal-on-scroll delay-100 text-lg text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    Avis Google, cartes de fidélité et messages clients. La solution tout-en-un pour développer votre
                    commerce sans être un expert en informatique.
                </p>

                <div
                    class="reveal-on-scroll delay-200 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    {{-- DECOUVRIR -> Page OFFRE (subscription.index) --}}
                    <a href="{{ route('subscription.index') }}"
                        class="w-full sm:w-auto px-8 py-4 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-500 rounded-xl transition-all shadow-xl shadow-emerald-500/20 transform hover:-translate-y-1">
                        Découvrir la solution
                    </a>

                    <div class="text-sm text-gray-500 font-medium sm:ml-4">
                        <span class="text-emerald-600 font-bold">+500</span> commerçants nous font confiance.
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: 3 BLOCKS GRID (Compact) -->
            <div class="flex-1 w-full max-w-lg lg:max-w-none">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">

                    <!-- CARD 1: GOOGLE REVIEWS -->
                    <div
                        class="reveal-on-scroll delay-100 bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover-lift flex items-start gap-4">
                        <div
                            class="h-12 w-12 shrink-0 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 animate-float">
                            {{-- G Icon --}}
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .533 5.333.533 12S5.867 24 12.48 24c3.44 0 6.013-1.133 8.053-3.24 2.107-2.107 2.76-5.067 2.76-7.84 0-.76-.08-1.467-.187-2l-10.627.001z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Votre Réputation</h3>
                            <p class="text-sm text-gray-500 leading-snug mt-1">
                                Obtenez plus d'avis 5 étoiles et suivez la satisfaction de vos clients.
                            </p>
                        </div>
                    </div>

                    <!-- CARD 2: WALLET -->
                    <div
                        class="reveal-on-scroll delay-200 bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover-lift flex items-start gap-4">
                        <div class="h-12 w-12 shrink-0 bg-gray-900 rounded-xl flex items-center justify-center text-white animate-float"
                            style="animation-delay: 1s;">
                            {{-- Wallet Icon --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Carte de Fidélité</h3>
                            <p class="text-sm text-gray-500 leading-snug mt-1">
                                Une carte moderne dans le téléphone de vos clients (Wallet). Simple et efficace.
                            </p>
                        </div>
                    </div>

                    <!-- CARD 3: MARKETING -->
                    <div
                        class="reveal-on-scroll delay-300 bg-white p-5 rounded-2xl shadow-sm border border-gray-100 hover-lift flex items-start gap-4">
                        <div class="h-12 w-12 shrink-0 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 animate-float"
                            style="animation-delay: 2s;">
                            {{-- Megaphone --}}
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg">Communication</h3>
                            <p class="text-sm text-gray-500 leading-snug mt-1">
                                Gardez le contact par SMS et Email. Relancez vos clients automatiquement.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- FOOTER LINKS SIMPLE -->
        <div
            class="max-w-7xl mx-auto px-6 w-full mt-10 text-center sm:text-left border-t border-gray-200 pt-6 reveal-on-scroll delay-300">
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-gray-400">
                <span>&copy; {{ date('Y') }} ShouCloud.</span>
                <div class="flex gap-4">
                    <a href="{{ route('terms.show') }}" class="hover:text-emerald-600">CGU</a>
                    <a href="{{ route('policy.show') }}" class="hover:text-emerald-600">Confidentialité</a>
                    <a href="{{ route('sales.show') }}" class="hover:text-emerald-600">CGV</a>
                </div>
            </div>
        </div>

    </main>

    <x-cookie-banner />

    <script>
        // Simple Intersection Observer for scroll reveal
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.reveal-on-scroll').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>