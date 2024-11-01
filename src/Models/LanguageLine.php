<?php

namespace Justbetter\StatamicTranslationManagement\Models;

use Spatie\TranslationLoader\LanguageLine as SpatieLanguageLine;
use StatamicRadPack\Runway\Traits\HasRunwayResource;

class LanguageLine extends SpatieLanguageLine
{
    use HasRunwayResource;
}
