<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-ivory dark:bg-emerald-dark min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-6 sm:p-12 shadow-sm border border-gray-100 dark:border-gray-700 mt-8">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-6">À propos de <span
                        class="text-emerald-600 dark:text-emerald-400">{{ config('app.name') }}</span></h1>

                <div class="prose prose-lg dark:prose-invert text-gray-600 dark:text-gray-300">
                    <p>
                        Nous sommes une équipe dédiée de développeurs, designers et marketeurs passionnés par l'aide aux
                        petites
                        et moyennes entreprises pour prospérer à l'ère du numérique.
                    </p>
                    <p>
                        Fondé avec une mission simple : <strong>Rendre les outils de croissance de niveau entreprise
                            accessibles à tous.</strong>
                    </p>

                    <h2>Notre Mission</h2>
                    <p>
                        Autonomiser les commerces locaux avec la technologie dont ils ont besoin pour rivaliser avec les
                        géants. Nous croyons
                        que les bons logiciels ne devraient pas être compliqués ou coûteux.
                    </p>

                    <h2>Nos Valeurs</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Simplicité :</strong> Si ça nécessite un manuel, c'est trop complexe.</li>
                        <li><strong>Transparence :</strong> Pas de frais cachés, pas de vente de données.</li>
                        <li><strong>Succès Client :</strong> Nous ne grandissons que lorsque vous grandissez.</li>
                    </ul>
                </div>
            </div>

                <div class="max-w-xl mx-auto mt-16">
                    @livewire('lead-capture', ['withDetails' => true])
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>