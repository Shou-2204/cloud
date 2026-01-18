<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-white dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div class="lg:grid lg:grid-cols-2 lg:gap-16 items-center mt-12">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl mb-6">
                        {{ $data['title'] }}
                    </h1>
                    <div class="prose prose-lg dark:prose-invert text-gray-600 dark:text-gray-300 mb-8">
                        <p>{{ $data['description'] }}</p>
                        <p>Detailed content about {{ $slug }} solutions would go here. Structured to target keywords
                            like "Best CRM for {{ $slug }}" or "{{ $slug }} loyalty software".</p>
                        <ul>
                            <li>Feature 1 specifically for {{ $slug }}</li>
                            <li>Feature 2 saving time for {{ $slug }} owners</li>
                            <li>Feature 3 increasing revenue</li>
                        </ul>
                    </div>
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('subscription.index') }}"
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
                            Start Free Trial
                        </a>
                        <a href="{{ route('contact') }}"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-full text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                            Talk to Sales
                        </a>
                    </div>
                </div>
                <div class="mt-12 lg:mt-0 relative">
                    <div
                        class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-3xl transform rotate-3 opacity-20 blur-xl">
                    </div>
                    <div
                        class="relative bg-gray-100 dark:bg-gray-800 rounded-3xl p-8 h-96 flex items-center justify-center">
                        <span class="text-gray-400 font-medium">Illustration for {{ ucfirst($slug) }}</span>
                    </div>
                </div>
            </div>

            <!-- Specific Features Section -->
            <section class="mt-24">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-12 text-center">Why top {{ $slug }}
                    businesses choose us</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature Cards Placeholder -->
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <h3 class="font-bold text-xl mb-2 dark:text-white">Review Automation</h3>
                        <p class="text-gray-600 dark:text-gray-400">Automatically collect 5-star reviews on Google.</p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <h3 class="font-bold text-xl mb-2 dark:text-white">Customer Database</h3>
                        <p class="text-gray-600 dark:text-gray-400">Build a list of your best customers automatically.
                        </p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <h3 class="font-bold text-xl mb-2 dark:text-white">SMS Campaign</h3>
                        <p class="text-gray-600 dark:text-gray-400">Bring customers back on slow days.</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-guest-layout>