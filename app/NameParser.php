<?php

namespace App;

use Illuminate\Support\Arr;

class NameParser
{
    private string $input;

    private array $parts;

    public function __construct(string $input)
    {
        $this->input = $this->sanitize($input);
        $this->parts = explode(' ', $this->input);
    }

    private function sanitize(string $input): string
    {
        return str_replace('.', '', $input);
    }

    public function parse(): array
    {
        return [
            'title' => $this->parseTitle(),
            'first_name' => $this->parseFirstName(),
            'initial' => $this->parseInitial(),
            'last_name' => $this->parseLastName(),
        ];
    }

    private function parseTitle(): string
    {
        return $this->parts[0];
    }

    private function parseFirstName(): ?string
    {
        if (! $this->hasFirstNameOrInitial()) {
            return null;
        }

        if (strlen($this->parts[1]) < 2) {
            return null;
        }

        return $this->parts[1];
    }

    private function parseInitial(): ?string
    {
        if (! $this->hasFirstNameOrInitial()) {
            return null;
        }

        if (strlen($this->parts[1]) > 1) {
            return null;
        }

        return $this->parts[1];
    }

    private function parseLastName(): string
    {
        return Arr::last($this->parts);
    }

    private function hasFirstNameOrInitial(): bool
    {
        return count($this->parts) > 2;
    }
}
