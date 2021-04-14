<?php

namespace App\Exceptions;

class CsvParserException extends \Exception
{
    /** @return static */
    public static function fileNotFound(string $path)
    {
        return new static("File `{$path}` not found.");
    }
}
