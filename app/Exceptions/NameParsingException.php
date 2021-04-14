<?php

namespace App\Exceptions;

class NameParsingException extends \Exception
{
    /** @return static */
    public static function notEnoughArguments(string $input)
    {
        return new static("Not enough parts from input `{$input}`");
    }
}
