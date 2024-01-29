<?php

namespace Abhiaay\Importable;

use Abhiaay\Importable\Type\Config;

class Message
{
    public function get(string $key, string $file = 'error'): string
    {
        return trans(Config::LANG_KEY->value . "::$file.$key");
    }
}
