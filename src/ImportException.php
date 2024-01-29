<?php

namespace Abhiaay\Importable;

use Exception;

class ImportException extends Exception
{
    public function __construct(protected array $errors, public bool $isPartial = false)
    {
        parent::__construct();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFirstError()
    {
        return $this->errors[0]['message'];
    }
}
