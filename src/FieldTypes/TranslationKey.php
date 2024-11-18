<?php

namespace Justbetter\StatamicTranslationManagement\Fieldtypes;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Statamic\Fieldtypes\Select;

class TranslationKey extends Select
{
    protected $indexComponent = 'tags';

    protected $component = 'select';

    public function preProcessIndex($value)
    {
        $values = $this->preProcess($value);

        $values = collect(is_array($values) ? $values : [$values]);

        return $values->map(function ($value) {
            return $value;
        })->all();
    }

    protected function getOptions(): array
    {
        $translationKeys = [];
        $functions = [
            'trans',
            'trans_choice',
            'Lang::get',
            'Lang::choice',
            'Lang::trans',
            'Lang::transChoice',
            '@lang',
            '@choice',
            '__',
            '$trans.get',
        ];

        $stringPattern =
            "[^\w]".                                       // Must not have an alphanum before real method
            '('.implode('|', $functions).')'.          // Must start with one of the functions
            "\(\s*".                                       // Match opening parenthesis
            "(?P<quote>['\"])".                            // Match " or ' and store in {quote}
            "(?P<string>(?:\\\k{quote}|(?!\k{quote}).)*)". // Match any string that can be {quote} escaped
            "\k{quote}".                                   // Match " or ' previously matched
            "\s*[\),]";                                     // Close parentheses or new parameter

        $files = [];

        $iterator = new RecursiveDirectoryIterator(resource_path());

        foreach (new RecursiveIteratorIterator($iterator) as $file) {
            if (strpos($file, '.blade.php') !== false) {
                $files[] = $file->getRealPath();
            }
        }

        foreach ($files as $file) {
            $contents = file_get_contents($file);

            if (preg_match_all("/{$stringPattern}/siU", $contents, $matches)) {
                foreach ($matches['string'] as $key) {
                    $translationKeys[] = $key;
                }
            }
        }

        return collect($translationKeys)->unique()->mapWithKeys(fn ($key) => [$key => $key])->toArray();
    }

    protected function configFieldItems(): array
    {
        return [
            [
                'display' => __('Selection'),
                'fields' => [
                    'placeholder' => [
                        'display' => __('Placeholder'),
                        'instructions' => __('statamic::fieldtypes.select.config.placeholder'),
                        'type' => 'text',
                        'default' => '',
                    ],
                    'multiple' => [
                        'display' => __('Multiple'),
                        'instructions' => __('statamic::fieldtypes.select.config.multiple'),
                        'type' => 'toggle',
                        'default' => false,
                    ],
                    'max_items' => [
                        'display' => __('Max Items'),
                        'instructions' => __('statamic::messages.max_items_instructions'),
                        'min' => 1,
                        'type' => 'integer',
                    ],
                    'clearable' => [
                        'display' => __('Clearable'),
                        'instructions' => __('statamic::fieldtypes.select.config.clearable'),
                        'type' => 'toggle',
                        'default' => false,
                    ],
                    'searchable' => [
                        'display' => __('Searchable'),
                        'instructions' => __('statamic::fieldtypes.select.config.searchable'),
                        'type' => 'toggle',
                        'default' => true,
                    ],
                ],
            ],
            [
                'display' => __('Data'),
                'fields' => [
                    'cast_booleans' => [
                        'display' => __('Cast Booleans'),
                        'instructions' => __('statamic::fieldtypes.any.config.cast_booleans'),
                        'type' => 'toggle',
                        'default' => false,
                    ],
                    'default' => [
                        'display' => __('Default Value'),
                        'instructions' => __('statamic::messages.fields_default_instructions'),
                        'type' => 'text',
                    ],
                ],
            ],
        ];
    }
}
