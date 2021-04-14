<?php

namespace Tests\Unit\ValueObjects;

use App\Exceptions\NamesParsingException;
use App\ValueObjects\Names;
use PHPUnit\Framework\TestCase;

class NamesTest extends TestCase
{
    /**
     * @test
     * @dataProvider singleNameProvider
     */
    public function it_parses_a_single_name(
        string $input,
        string $expectation
    ): void
    {
        $names = new Names($input);

        $this->assertCount(1, $names->all());
        $this->assertEquals($expectation, (string) $names->all()[0]);
    }

    /**
     * @test
     * @dataProvider multipleNameProvider
     */
    public function it_parses_two_names(
        string $input,
        array $expectation
    ): void {
        $names = new Names($input);

        $this->assertCount(2, $names->all());

        foreach ($expectation as $key => $value) {
            $this->assertEquals($value, (string) $names->all()[$key]);
        }
    }

    /** @test */
    public function it_throws_an_error_for_too_many_names(): void
    {
        $this->expectException(NamesParsingException::class);
        $this->expectExceptionMessage("Too many names from input `Mr & Mrs & Mr Bloggs`");

        $names = new Names('Mr & Mrs & Mr Bloggs');
    }

    public function singleNameProvider(): array
    {
        return [
            'title, first name, last name' => [
                'Mr John Smith',
                'Mr John Smith',
            ],
            'title, initial, last name' => [
                'Mr J Smith',
                'Mr J Smith',
            ],
            'title, initial (with period), last name' => [
                'Mr J. Smith',
                'Mr J Smith',
            ],
        ];
    }

    public function multipleNameProvider(): array
    {
        return [
            'title and title, last name' => [
                'Mr and Mrs Smith',
                ['Mr Smith', 'Mrs Smith'],
            ],
            'title, first name, last name and title, first name, last name' => [
                'Mr Tom Staff and Mr John Doe',
                ['Mr Tom Staff', 'Mr John Doe'],
            ],
            'title & title first name last name' => [
                'Dr & Mrs Joe Bloggs',
                ['Dr Joe Bloggs', 'Mrs Joe Bloggs'],
            ],
        ];
    }
}
