<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-authentication-card-logo />
            </div>

            <div
                class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                <h1>Politique de Confidentialité</h1>
                <p><strong>Dernière mise à jour : {{ date('d/m/Y') }}</strong></p>

                <h2>1. Introduction</h2>
                <p>{{ config('app.name') }} s'engage à protéger la vie privée de ses utilisateurs. Cette politique de
                    confidentialité explique comment nous collectons, utilisons, divulguons et protégeons vos
                    informations personnelles lorsque vous utilisez notre Service.</p>

                <h2>2. Données collectées</h2>
                <p>Nous collectons les types d'informations suivants :</p>
                <ul>
                    <li><strong>Informations de compte :</strong> Nom, adresse email, photo de profil et mot de passe
                        chiffré.</li>
                    <li><strong>Informations de paiement :</strong> Données nécessaires au traitement des paiements
                        (gérées de manière sécurisée par notre prestataire Stripe).</li>
                    <li><strong>Données techniques :</strong> Adresse IP, type de navigateur, journaux de connexion à
                        des fins de sécurité et de débogage.</li>
                </ul>

                <h2>3. Utilisation des données</h2>
                <p>Vos données sont utilisées pour les finalités suivantes :</p>
                <ul>
                    <li>Fournir et maintenir le Service.</li>
                    <li>Gérer votre abonnement et les transactions financières.</li>
                    <li>Vous notifier des changements importants ou des mises à jour du Service.</li>
                    <li>Assurer la sécurité de votre compte et prévenir la fraude.</li>
                </ul>

                <h2>4. Partage des données</h2>
                <p>Nous ne vendons jamais vos données personnelles. Nous pouvons partager vos informations avec des
                    tiers de confiance uniquement dans les cas suivants :</p>
                <ul>
                    <li><strong>Prestataires de services :</strong> Hébergement (AWS), Paiement (Stripe), Emailing,
                        nécessaires au fonctionnement du Service.</li>
                    <li><strong>Obligations légales :</strong> Si la loi nous y oblige ou pour protéger nos droits.</li>
                </ul>

                <h2>5. Sécurité des données</h2>
                <p>Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles appropriées pour
                    protéger vos données contre l'accès non autorisé, la modification, la divulgation ou la destruction.
                    Vos mots de passe sont toujours hachés et nos échanges sont chiffrés (TLS/SSL).</p>

                <h2>6. Vos droits</h2>
                <p>Conformément au RGPD et à la loi Informatique et Libertés, vous disposez des droits suivants :</p>
                <ul>
                    <li>Droit d'accès et de rectification de vos données.</li>
                    <li>Droit à l'effacement (droit à l'oubli).</li>
                    <li>Droit à la limitation du traitement.</li>
                    <li>Droit à la portabilité des données.</li>
                </ul>
                <p>Vous pouvez exercer ces droits directement depuis les paramètres de votre compte ou en nous
                    contactant.</p>

                <h2>7. Cookies</h2>
                <p>Nous utilisons des cookies essentiels pour maintenir votre session de connexion et assurer la
                    sécurité du site. Nous n'utilisons pas de cookies publicitaires ou de traçage tiers sans votre
                    consentement explicite.</p>

                <h2>8. Contact</h2>
                <p>Pour toute question concernant cette politique de confidentialité, vous pouvez nous contacter à
                    l'adresse suivante : support@shou-cloud.com</p>
            </div>
        </div>
    </div>
</x-guest-layout>