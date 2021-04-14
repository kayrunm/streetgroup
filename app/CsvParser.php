<?php

namespace App;

use App\Exceptions\CsvParserException;
use App\ValueObjects\Names;
use Illuminate\Support\Arr;

class CsvParser
{
    private bool $withHeader = true;

    /** @return $this */
    public function withoutHeader()
    {
        $this->withHeader = false;

        return $this;
    }

    /** @return \App\ValueObjects\Name */
    public function parse(string $path): array
    {
        $file = $this->openFile($path);
        $rows = [];

        // If this file has a header, read a row and just move on.
        if ($this->withHeader) {
            fgetcsv($file);
        }

        while (($row = fgetcsv($file)) !== false) {
            $rows[] = (new Names($row[0]))->all();
        }

        return Arr::flatten($rows);
    }

    /** @return resource */
    private function openFile(string $path)
    {
        if (! file_exists($path)) {
            throw CsvParserException::fileNotFound($path);
        }

        return fopen($path, 'r');
    }
}
