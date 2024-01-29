<?php

namespace Abhiaay\Importable;

use Abhiaay\Importable\Type\Config;
use Abhiaay\Importable\Type\ImportColumn;

abstract class Import
{
    private array $errors = [];

    /**
     * Validate your row data import
     */
    abstract protected function doValidate(array $row, ImportColumn $column): ValidateResponse;

    /**
     * Logic how import is saved or being processed
     *
     * @throws Exception
     */
    abstract protected function processImport(int $index, array $row): void;


    public function __construct(protected array &$rows, protected array $headers, protected mixed $columns)
    {
    }

    public function validation(): bool
    {
        // check if number headers is equal
        if (count($this->headers) !== count($this->columns::cases())) {
            $this->addError(message: trans(Config::LANG_KEY->value . '::error.invalid_number_of_headers_import'));
            return false;
        }

        foreach ($this->rows as $index => $row) {
            $response = $this->validate($row);
            if (!$response->isValid) {
                $this->addError($index, $response->column, $response->message);
            }
        }

        if (count($this->errors) > 0) {
            return false;
        }
        return true;
    }

    public function import(): void
    {
        foreach ($this->rows as $index => $row) {
            try {
                $this->processImport($index, $row);
            } catch (\Exception $e) {
                $this->addError($index, message: trans(Config::LANG_KEY->value . '::error.row_import_failed', ['row' => $index + 1]));
            }
        }
    }

    private function validate(array $row): ValidateResponse
    {
        foreach ($this->columns::cases() as $column) {
            $validateResponse = $this->doValidate($row, $column);
            if (!$validateResponse->isValid) {
                return $validateResponse;
            }
        }
        return new ValidateResponse(true);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return count($this->errors) > 0;
    }

    private function addError(int $row = null, string $column = null, string $message = null)
    {
        $error = [];

        if (!is_null($row)) {
            $error['row'] = $row + 1;
        }

        if (!empty($column)) {
            $error['column'] = $column;
        }

        if (!empty($message)) {
            $error['message'] = $message;
        }

        $this->errors[] = $error;
    }
}
