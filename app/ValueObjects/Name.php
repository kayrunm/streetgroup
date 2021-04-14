<?php

namespace App\ValueObjects;

use App\Exceptions\NameParsingException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Name
{
    private array $parts;

    public function __construct(string $input)
    {
        $this->parts = explode(' ', $this->sanitize($input));

        if (count($this->parts) < 2) {
            throw NameParsingException::notEnoughArguments($input);
        }
    }

    public function getTitle(): string
    {
        return $this->parts[0];
    }

    public function getFirstName(): ?string
    {
        if (! $this->hasFirstNameOrInitial()) {
            return null;
        }

        if (strlen($this->parts[1]) < 2) {
            return null;
        }

        return $this->parts[1];
    }

    public function getInitial(): ?string
    {
        if (! $this->hasFirstNameOrInitial()) {
            return null;
        }

        if (strlen($this->parts[1]) > 1) {
            return null;
        }

        return $this->parts[1];
    }

    public function getLastName(): string
    {
        return Arr::last($this->parts);
    }

    public function __toString(): string
    {
        return Collection::make([
            $this->getTitle(),
            $this->getInitial(),
            $this->getFirstName(),
            $this->getLastName(),
        ])->filter()->join(' ');
    }

    private function sanitize(string $input): string
    {
        return str_replace('.', '', $input);
    }

    private function hasFirstNameOrInitial(): bool
    {
        return count($this->parts) > 2;
    }
}
