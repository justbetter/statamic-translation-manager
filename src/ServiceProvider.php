<?php

namespace Justbetter\StatamicTranslationManagement;

use Justbetter\StatamicTranslationManagement\Fieldtypes\LocaleSelectArray;
use Justbetter\StatamicTranslationManagement\Fieldtypes\TranslationKey;
use Justbetter\StatamicTranslationManagement\Models\LanguageLine;
use Spatie\TranslationLoader\TranslationServiceProvider;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    // @phpstan-ignore-next-line
    protected $vite = [
        'input' => [
            'resources/js/translation-manager.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function register()
    {
        $this->app->register(TranslationServiceProvider::class, true);
    }

    public function bootAddon(): void
    {
        $this->bootRunway()
            ->bootPublishables()
            ->bootFieldTypes();
    }

    protected function bootRunway(): self
    {
        config(['runway.resources' => array_merge(
            [LanguageLine::class => [
                'name' => 'Translations',
            ]],
            config('runway.resources') ?? []
        )]);

        return $this;
    }

    protected function bootPublishables(): self
    {
        $this->publishes([
            __DIR__.'/../resources/blueprints/vendor/runway' => resource_path('blueprints/vendor/runway'),
        ]);

        return $this;
    }

    protected function bootFieldTypes(): self
    {
        TranslationKey::register();
        LocaleSelectArray::register();

        return $this;
    }
}
