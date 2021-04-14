<?php

namespace App\ValueObjects;

use Illuminate\Support\Arr;

class Name
{
    private string $input;

    private array $parts;

    public function __construct(string $input)
    {
        $this->input = $this->sanitize($input);
        $this->parts = explode(' ', $this->input);
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

    private function sanitize(string $input): string
    {
        return str_replace('.', '', $input);
    }

    private function hasFirstNameOrInitial(): bool
    {
        return count($this->parts) > 2;
    }
}
