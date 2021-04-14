<?php

namespace App\Exceptions;

class NamesParsingException extends \Exception
{
    /** @return static */
    public static function tooManyNames(string $input)
    {
        return new static("Too many names from input `{$input}`");
    }
}
