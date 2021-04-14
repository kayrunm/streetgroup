<?php

namespace Tests\Unit\ValueObjects;

use App\ValueObjects\Name;
use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    /**
     * @test
     * @dataProvider nameProvider
    */
    public function it_parses_titles(
        string $input,
        array $expectation
    ): void {
        $name = new Name($input);

        $this->assertSame($expectation['title'], $name->getTitle());
    }

    /**
     * @test
     * @dataProvider nameProvider
    */
    public function it_parses_initials(
        string $input,
        array $expectation
    ): void {
        $name = new Name($input);

        $this->assertSame($expectation['initial'], $name->getInitial());
    }

    /**
     * @test
     * @dataProvider nameProvider
    */
    public function it_parses_first_names(
        string $input,
        array $expectation
    ): void {
        $name = new Name($input);

        $this->assertSame($expectation['first name'], $name->getFirstName());
    }

    /**
     * @test
     * @dataProvider nameProvider
    */
    public function it_parses_last_names(
        string $input,
        array $expectation
    ): void {
        $name = new Name($input);

        $this->assertSame($expectation['last name'], $name->getLastName());
    }

    public function nameProvider(): array
    {
        return [
            'title, first name, last name' => [
                'Mr John Smith', [
                    'title' => 'Mr',
                    'initial' => null,
                    'first name' => 'John',
                    'last name' => 'Smith',
                ],
            ],
            'title, initial, last name' => [
                'Mr J Smith', [
                    'title' => 'Mr',
                    'initial' => 'J',
                    'first name' => null,
                    'last name' => 'Smith',
                ],
            ],
            'title, initial (with period), last name' => [
                'Mr J. Smith', [
                    'title' => 'Mr',
                    'initial' => 'J',
                    'first name' => null,
                    'last name' => 'Smith',
                ],
            ],
        ];
    }
}
