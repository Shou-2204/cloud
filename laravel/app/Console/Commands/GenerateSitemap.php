<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.xml file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ensure the public path exists
        $path = public_path('sitemap.xml');

        $this->info('Generating sitemap...');

        // Create sitemap
        $sitemap = Sitemap::create();

        // Add static pages
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/pricing')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            ->add(Url::create('/solutions')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/about')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY))
            ->add(Url::create('/contact')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY))
            ->add(Url::create('/blog')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));

        // Add Dynamic Solutions (In real app, fetch from DB)
        $solutions = ['restaurants', 'retail', 'services'];
        foreach ($solutions as $slug) {
            $sitemap->add(Url::create("/solutions/{$slug}")
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        }

        // Add Dynamic Blog Posts (In real app, fetch from DB)
        $posts = ['boost-seo-2026', 'customer-retention'];
        foreach ($posts as $slug) {
            $sitemap->add(Url::create("/blog/{$slug}")
                ->setPriority(0.6)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        }

        // Add Public Team Profiles (Only Subscribed)
        $this->info('Adding subscribed teams...');
        \App\Models\Team::query()->cursor()->each(function (\App\Models\Team $team) use ($sitemap) {
            // Check if team has active subscription and public page enabled (implicit by not being personal usually, but handled by controller logic)
            // We reuse the controller logic: must be subscribed.
            if ($team->subscribed()) {
                 $sitemap->add(Url::create(route('profile.public', $team->public_uuid))
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            }
        });

        $sitemap->writeToFile($path);

        $this->info("Sitemap generated at: {$path}");
    }
}
