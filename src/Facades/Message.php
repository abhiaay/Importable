<?php

namespace Abhiaay\Importable\Facades;

use Abhiaay\Importable\Message as ImportableMessage;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string get(string $key, string $file = null)
 */
class Message extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return ImportableMessage::class;
    }
}
