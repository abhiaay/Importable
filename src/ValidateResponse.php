<?php

namespace Abhiaay\Importable;

class ValidateResponse
{
    public function __construct(
        public readonly bool $isValid,
        public readonly ?string $message = null,
        public readonly ?string $column = null
    ) {
    }
}
