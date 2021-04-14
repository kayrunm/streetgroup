<?php

namespace Tests\Unit;

use App\CsvParser;
use App\Exceptions\CsvParserException;
use PHPUnit\Framework\TestCase;

class CsvParserTest extends TestCase
{
    /**
     * @test
     * @dataProvider successfulParsingProvider
    */
    public function it_parses_a_csv_file(array $rows): void
    {
        $names = (new CsvParser())->parse('./resources/csvs/examples.csv');

        $this->assertCount(18, $names);

        foreach ($rows as $index => $expectation) {
            $this->assertEquals($expectation, (string) $names[$index]);
        }
    }

    /**
     * @test
     * @dataProvider successfulParsingProvider
    */
    public function it_parses_a_csv_file_without_a_header(array $rows): void
    {
        $names = (new CsvParser())
            ->withoutHeader()
            ->parse('./resources/csvs/examples_without_header.csv', false);

        $this->assertCount(18, $names);

        foreach ($rows as $index => $expectation) {
            $this->assertEquals($expectation, (string) $names[$index]);
        }
    }

    /** @test */
    public function it_throws_an_error_for_file_that_doesnt_exist(): void
    {
        $this->expectException(CsvParserException::class);
        $this->expectExceptionMessage('File `myfile.csv` not found.');

        (new CsvParser())->parse('myfile.csv');
    }

    public function successfulParsingProvider(): array
    {
        return [
            [
                [
                    'Mr John Smith',
                    'Mrs Jane Smith',
                    'Mister John Doe',
                    'Mr Bob Lawblaw',
                    'Mr Smith',
                    'Mrs Smith',
                    'Mr Craig Charles',
                    'Mr M Mackie',
                    'Mrs Jane McMaster',
                    'Mr Tom Staff',
                    'Mr John Doe',
                    'Dr P Gunn',
                    'Dr Joe Bloggs',
                    'Mrs Joe Bloggs',
                    'Ms Claire Robbo',
                    'Prof Alex Brogan',
                    'Mrs Faye Hughes-Eastwood',
                    'Mr F Fredrickson',
                ]
            ],
        ];
    }
}
