<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ouvrir dans le navigateur</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-100 flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden text-center p-8">
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-indigo-100 mb-6">
            <svg class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </div>

        <h2 class="text-2xl font-bold text-gray-900 mb-2">
            Navigateur non supporté
        </h2>

        <p class="text-gray-600 mb-8">
            Pour des raisons de sécurité, Google ne permet pas la connexion depuis l'application (Messenger/Instagram).
        </p>

        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100 text-left">
            <p class="font-semibold text-indigo-900 text-sm mb-2">Comment faire ?</p>
            <ol class="list-decimal list-inside text-indigo-800 text-sm space-y-1">
                <li>Appuyez sur les <span class="font-bold">3 points</span> (menu) en haut ou en bas de l'écran.</li>
                <li>Sélectionnez <span class="font-bold">"Ouvrir dans le navigateur"</span> (ou Chrome/Safari).</li>
            </ol>
        </div>
        
        <div class="mt-6 text-xs text-gray-400">
            Une fois dans votre navigateur habituel, la connexion fonctionnera immédiatement.
        </div>
    </div>

</body>
</html>
