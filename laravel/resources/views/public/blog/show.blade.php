<x-guest-layout :seo="$seo">
    <div class="pt-24 pb-12 bg-white dark:bg-gray-900 min-h-screen">
        <article class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-breadcrumb :crumbs="$seo['breadcrumbs']" />

            <header class="mb-12 text-center">
                <div class="space-y-1 text-center">
                    <dl class="space-y-10">
                        <div>
                            <dt class="sr-only">Published on</dt>
                            <dd class="text-base leading-6 font-medium text-gray-500 dark:text-gray-400">
                                <time datetime="2026-01-18">Sunday, January 18, 2026</time>
                            </dd>
                        </div>
                    </dl>
                    <div>
                        <h1
                            class="text-3xl leading-9 font-extrabold text-gray-900 dark:text-white sm:text-4xl sm:leading-10 md:text-5xl md:leading-14">
                            Strategies to Boost Your Local SEO in 2026
                        </h1>
                    </div>
                </div>
            </header>

            <div class="prose prose-lg dark:prose-invert mx-auto">
                <p>
                    This is a placeholder for the blog post content. In a real application, you would render the
                    markdown or HTML content of the post here.
                </p>
                <p>
                    <strong>Slug:</strong> {{ $slug }}
                </p>
                <h2>Key Takeaways</h2>
                <ul>
                    <li>Focus on Mobile First UX</li>
                    <li>Gather consistent Reviews</li>
                    <li>Utilize Structured Data</li>
                </ul>
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.
                </p>
            </div>
        </article>
    </div>
</x-guest-layout>