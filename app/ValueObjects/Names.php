<?php

namespace App\ValueObjects;

use App\Exceptions\NameParsingException;
use App\Exceptions\NamesParsingException;
use Illuminate\Support\Collection;

class Names
{
    public function __construct(string $input)
    {
        $this->parts = $this->split($input);

        if (count($this->parts) >2) {
            throw NamesParsingException::tooManyNames($input);
        }
    }

    /** @return  \App\ValueObjects\Name[] */
    public function all(): array
    {
        $master = new Name($this->parts[0]);

        if (count($this->parts) < 2) {
            return [$master];
        }

        return [
            $this->parseNameWithMaster($this->parts[1], $master),
            $master,
        ];
    }

    private function parseNameWithMaster(string $name, Name $master): Name
    {
        try {
            return new Name($name);
        } catch (NameParsingException $e) {
            return new Name("{$name} {$master->getFirstName()} {$master->getLastName()}");
        }
    }

    private function split(string $input): array
    {
        $input = str_replace('and', '&', $input);

        return Collection::make(explode('&', $input))
            ->reverse()
            ->map(fn ($part) => trim($part))
            ->values()
            ->toArray();
    }
}
