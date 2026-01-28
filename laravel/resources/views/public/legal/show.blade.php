<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 dark:border-gray-700 mt-8">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8">
                    @if($page == 'terms') Terms of Service @else Privacy Policy @endif
                </h1>

                <div class="prose prose-sm sm:prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                    @if($page == 'terms')
                        <p>These terms and conditions outline the rules and regulations for the use of
                            {{ config('app.name') }}'s Website.
                        </p>
                        <h3>1. Introduction</h3>
                        <p>By accessing this website we assume you accept these terms and conditions. Do not continue to use
                            {{ config('app.name') }} if you do not agree to take all of the terms and conditions stated on
                            this page.
                        </p>
                        <!-- In real app, include markdown('terms.md') -->
                    @else
                        <p>At {{ config('app.name') }}, accessible from
                            {{ str_replace(['http://', 'https://'], '', config('app.url')) }}, one of our main priorities is
                            the privacy of our
                            visitors. This Privacy Policy document contains types of information that is collected and
                            recorded by {{ config('app.name') }} and how we use it.</p>
                        <h3>1. Log Files</h3>
                        <p>{{ config('app.name') }} follows a standard procedure of using log files. These files log
                            visitors when they
                            visit websites.</p>
                        <!-- In real app, include markdown('policy.md') -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>