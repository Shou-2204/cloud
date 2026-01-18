<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div class="max-w-3xl mx-auto items-center mt-8">
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-12 sm:px-12 sm:py-16">
                        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl mb-6">
                            Get in touch
                        </h2>
                        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                            Have questions about our solutions? We're here to help.
                        </p>

                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="ml-3 text-base text-gray-500 dark:text-gray-400">
                                    <p>support@shoucloud.com</p>
                                    <p class="mt-1">sales@shoucloud.com</p>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Sales & Support Hours</h3>
                                <p class="mt-2 text-base text-gray-500 dark:text-gray-400">
                                    Monday - Friday: 9am - 6pm (CET)
                                </p>
                            </div>
                        </div>

                        <div class="mt-8">
                            <!-- Placeholder for Contact Form -->
                            <form action="#" method="POST" class="grid grid-cols-1 gap-y-6">
                                <div>
                                    <label for="email"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                    <div class="mt-1">
                                        <input type="email" name="email" id="email"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            placeholder="you@example.com">
                                    </div>
                                </div>
                                <div>
                                    <label for="message"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Message</label>
                                    <div class="mt-1">
                                        <textarea id="message" name="message" rows="4"
                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                            placeholder="How can we help?"></textarea>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>