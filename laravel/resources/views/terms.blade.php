<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-authentication-card-logo />
            </div>

            <div
                class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                <h1>Conditions Générales d'Utilisation (CGU)</h1>
                <p><strong>Dernière mise à jour : {{ date('d/m/Y') }}</strong></p>

                <h2>1. Objet</h2>
                <p>Les présentes Conditions Générales d'Utilisation ont pour objet de définir les modalités de mise à
                    disposition des services du site <strong>{{ config('app.name') }}</strong>, ci-après nommé « le
                    Service » et les
                    conditions d'utilisation du Service par l'Utilisateur.</p>

                <h2>2. Accès au site et aux services</h2>
                <p>Le Service permet à l'Utilisateur un accès gratuit et payant aux services suivants :</p>
                <ul>
                    <li>Gestion d'organisation et collaboration.</li>
                    <li>Gestion d'abonnements SaaS.</li>
                </ul>
                <p>Le site est accessible gratuitement en tout lieu à tout Utilisateur ayant un accès à Internet. Tous
                    les frais supportés pour accéder au service (matériel informatique, logiciels, connexion Internet,
                    etc.) sont à la charge de l'Utilisateur.</p>

                <h2>3. Propriété intellectuelle</h2>
                <p>Les marques, logos, signes ainsi que tous les contenus du site (textes, images, son...) font l'objet
                    d'une protection par le Code de la propriété intellectuelle et plus particulièrement par le droit
                    d'auteur.</p>
                <p>L'Utilisateur doit solliciter l'autorisation préalable du site pour toute reproduction, publication,
                    copie des différents contenus. Il s'engage à une utilisation des contenus du site dans un cadre
                    strictement privé, toute utilisation à des fins commerciales et publicitaires est strictement
                    interdite.</p>

                <h2>4. Données personnelles</h2>
                <p>Les informations demandées à l’inscription au site sont nécessaires et obligatoires pour la création
                    du compte de l'Utilisateur. En particulier, l'adresse électronique pourra être utilisée par le site
                    pour l'administration, la gestion et l'animation du service.</p>
                <p>Le site assure à l'Utilisateur une collecte et un traitement d'informations personnelles dans le
                    respect de la vie privée conformément à la loi n°78-17 du 6 janvier 1978 relative à l'informatique,
                    aux fichiers et aux libertés.</p>

                <h2>5. Responsabilité</h2>
                <p>Les sources des informations diffusées sur le site {{ config('app.name') }} sont réputées fiables
                    mais le site ne
                    garantit pas qu'il soit exempt de défauts, d'erreurs ou d'omissions.</p>
                <p>Le site ne peut être tenu pour responsable d’éventuels virus qui pourraient infecter l’ordinateur ou
                    tout matériel informatique de l’Internaute, suite à une utilisation, à l’accès, ou au téléchargement
                    provenant de ce site.</p>

                <h2>6. Liens hypertextes</h2>
                <p>Des liens hypertextes peuvent être présents sur le site. L’Utilisateur est informé qu’en cliquant sur
                    ces liens, il sortira du site {{ config('app.name') }}. Ce dernier n’a pas de contrôle sur les pages
                    web sur
                    lesquelles aboutissent ces liens et ne saurait, en aucun cas, être responsable de leur contenu.</p>

                <h2>7. Droit applicable et juridiction compétente</h2>
                <p>La législation française s'applique au présent contrat. En cas d'absence de résolution amiable d'un
                    litige né entre les parties, les tribunaux français seront seuls compétents pour en connaître.</p>
            </div>
        </div>
    </div>
</x-guest-layout>