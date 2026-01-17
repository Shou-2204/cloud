<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <x-authentication-card-logo />
            </div>

            <div
                class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                <h1>Conditions Générales de Vente (CGV)</h1>
                <p><strong>Dernière mise à jour : {{ date('d/m/Y') }}</strong></p>

                <h2>1. Objet</h2>
                <p>Les présentes Conditions Générales de Vente visent à définir les relations contractuelles entre
                    ShouCloud et l'acheteur et les conditions applicables à tout achat effectué par le biais du site
                    internet ShouCloud.</p>

                <h2>2. Tarifs</h2>
                <p>Les prix de nos abonnements sont indiqués en euros toutes taxes comprises (TTC), sauf indication
                    contraire et hors frais de traitement et d'expédition.</p>
                <p>ShouCloud se réserve le droit de modifier ses prix à tout moment, mais le produit sera facturé sur la
                    base du tarif en vigueur au moment de la validation de la commande.</p>

                <h2>3. Commandes et Abonnements</h2>
                <p>Les informations contractuelles sont présentées en langue française et feront l'objet d'une
                    confirmation au plus tard au moment de la validation de votre commande.</p>
                <p>Toute souscription à un abonnement vaut acceptation des prix et descriptions des services
                    disponibles.</p>

                <h2>4. Paiement</h2>
                <p>Le fait de valider votre commande implique pour vous l'obligation de payer le prix indiqué. Le
                    règlement de vos achats s'effectue par carte bancaire grâce au système sécurisé Stripe.</p>

                <h2>5. Rétractation</h2>
                <p>Conformément aux dispositions de l'article L.121-21-8 du Code de la Consommation, le droit de
                    rétractation ne s'applique pas à la fourniture d'un contenu numérique non fourni sur un support
                    matériel dont l'exécution a commencé après accord préalable exprès du consommateur et renoncement
                    exprès à son droit de rétractation.</p>
                <p>En souscrivant aux services ShouCloud, vous acceptez l'exécution immédiate du contrat et renoncez à
                    votre droit de rétractation.</p>

                <h2>6. Disponibilité</h2>
                <p>Nos services sont proposés tant qu'ils sont visibles sur le site ShouCloud. En cas d'indisponibilité
                    de service après passation de votre commande, nous vous en informerons par mail.</p>

                <h2>7. Responsabilité</h2>
                <p>Les services proposés sont conformes à la législation française en vigueur. La responsabilité de
                    ShouCloud ne saurait être engagée en cas de non-respect de la législation du pays où le service est
                    utilisé.</p>

                <h2>8. Données personnelles</h2>
                <p>ShouCloud se réserve le droit de collecter les informations nominatives et les données personnelles
                    vous concernant. Elles sont nécessaires à la gestion de votre commande, ainsi qu'à l'amélioration
                    des services et des informations que nous vous adressons.</p>

                <h2>9. Archivage Preuve</h2>
                <p>ShouCloud archivera les bons de commandes et les factures sur un support fiable et durable
                    constituant une copie fidèle conformément aux dispositions de l'article 1348 du Code civil.</p>
            </div>
        </div>
    </div>
</x-guest-layout>