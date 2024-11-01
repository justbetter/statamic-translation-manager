<?php

namespace Justbetter\StatamicTranslationManagement\Tests;

use Justbetter\StatamicTranslationManagement\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;

    protected function getPackageProviders($app)
    {
        return [
            ...parent::getPackageProviders($app),
            \StatamicRadPack\Runway\ServiceProvider::class,
        ];
    }
}
