<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <div
                class="bg-white dark:bg-gray-800 rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100 dark:border-gray-700 mt-8">
                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-6">About ShouCloud</h1>

                <div class="prose prose-lg dark:prose-invert text-gray-600 dark:text-gray-300">
                    <p>
                        We are a dedicated team of developers, designers, and marketers passionate about helping small
                        and medium businesses thrive in the digital age.
                    </p>
                    <p>
                        Founded with a simple mission: <strong>Make enterprise-grade growth tools accessible to
                            everyone.</strong>
                    </p>

                    <h2>Our Mission</h2>
                    <p>
                        To empower local businesses with the technology they need to compete with the giants. We believe
                        that great software shouldn't be complicated or expensive.
                    </p>

                    <h2>Our Values</h2>
                    <ul class="list-disc pl-5 space-y-2">
                        <li><strong>Simplicity:</strong> If it needs a manual, it's too complex.</li>
                        <li><strong>Transparency:</strong> No hidden fees, no data selling.</li>
                        <li><strong>Customer Success:</strong> We only grow when you grow.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 text-center">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Ready to grow with us?</h3>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-all">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>