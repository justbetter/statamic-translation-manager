# WIP
This addon is still a WIP.

# Statamic Translation Management

> Statamic Translation Management is a Statamic addon that allows you to add/edit translations.

## Features

This addon does:

- Edit translations
- Create translations

## How to Install

``` bash
composer require justbetter/statamic-translation-management
```

This addon makes use of [spatie/laravel-translation-loader](https://github.com/spatie/laravel-translation-loader), and has migrations. 
To publish and migrate, you can run:
```bash
php artisan vendor:publish --provider="Spatie\TranslationLoader\TranslationServiceProvider" --tag="migrations"
php artisan migrate
```

This addon adds two custom field types, if you want to use them include the script in your cp.js.
```js
import 'Vendor/justbetter/statamic-translation-management/resources/js/translation-manager.js'
```

## How to Use

This addon adds a "translations" menu item in the control panel through [Runway](https://github.com/statamic-rad-pack/runway). Here you can add/edit the translations.