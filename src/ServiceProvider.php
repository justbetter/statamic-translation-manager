<?php

namespace Justbetter\StatamicTranslationManagement;

use Justbetter\StatamicTranslationManagement\Models\LanguageLine;
use Spatie\TranslationLoader\TranslationServiceProvider;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function register()
    {
        $this->app->register(TranslationServiceProvider::class, true);
    }

    public function bootAddon(): void
    {
        config(['runway.resources' => array_merge(
            [LanguageLine::class => [
                'name' => 'Translations',
            ]],
            config('runway.resources') ?? []
        )]);
    }
}
