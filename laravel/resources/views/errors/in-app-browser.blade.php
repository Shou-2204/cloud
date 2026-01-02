<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Continuer sur le navigateur</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-indigo-500/20 rounded-full blur-3xl -z-10 pointer-events-none"></div>

    <div class="max-w-md w-full bg-white/80 backdrop-blur-lg rounded-2xl shadow-xl border border-white/50 p-8 text-center relative z-10">
        
        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-indigo-50 mb-6 animate-bounce">
            <svg class="h-10 w-10 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-gray-900 mb-3">
            On continue ailleurs ?
        </h1>

        <p class="text-gray-600 mb-8 leading-relaxed">
            Pour profiter pleinement de l'expérience ShouCloud et de toutes ses fonctionnalités, basculons simplement sur votre navigateur habituel.
        </p>

        <div class="bg-indigo-50/80 rounded-2xl p-5 text-left border border-indigo-100">
            <div class="space-y-4">
                <div class="flex items-center">
                    <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-indigo-200 text-indigo-700 font-bold text-sm">1</span>
                    <p class="ml-4 text-sm text-indigo-900">
                        Touchez les <span class="font-bold">3 petits points</span> (le menu).
                    </p>
                </div>
                <div class="flex items-center">
                    <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-indigo-200 text-indigo-700 font-bold text-sm">2</span>
                    <p class="ml-4 text-sm text-indigo-900">
                        Choisissez <span class="font-bold">"Ouvrir dans le navigateur"</span>.
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-xs text-gray-400 font-medium">
                À tout de suite sur Chrome ou Safari ! 👋
            </p>
        </div>
    </div>

</body>
</html>
