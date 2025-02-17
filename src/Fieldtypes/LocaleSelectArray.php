<?php

namespace Justbetter\StatamicTranslationManagement\Fieldtypes;

use Statamic\Facades\Site;
use Statamic\Fieldtypes\Arr;

class LocaleSelectArray extends Arr
{
    protected static $handle = 'locale_select_array';

    protected $indexComponent = 'locale_select_array_index'; // Custom index component

    public function preload(): array
    {
        return [
            'locales' => $this->getLocales(),
        ];
    }

    protected function getLocales(): array
    {
        return Site::all()
            ->pluck('lang')
            ->unique()
            ->toArray();
    }
}
