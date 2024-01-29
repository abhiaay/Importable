<?php

namespace Abhiaay\Importable;

use Abhiaay\Importable\Type\Config;
use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = dirname(__FILE__) . '/lang';

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, Config::LANG_KEY->value);
            $this->loadJsonTranslationsFrom($langPath);
        }
    }
}
