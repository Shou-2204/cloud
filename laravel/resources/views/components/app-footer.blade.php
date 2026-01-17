<footer class="bg-white dark:bg-emerald-dark-500 border-t border-gray-100 dark:border-emerald-dark-600 mt-auto">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex justify-center space-x-6 md:order-2">
                <a href="{{ route('subscription.index') }}"
                    class="text-sm text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">
                    Offres
                </a>
                <a href="{{ route('terms.show') }}"
                    class="text-sm text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">
                    CGU
                </a>
                <a href="{{ route('sales.show') }}"
                    class="text-sm text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">
                    CGV
                </a>
            </div>
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} ShouCloud. Tous droits réservés.
                </p>
            </div>
        </div>
    </div>
</footer>