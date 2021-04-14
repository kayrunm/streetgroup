<?php

namespace Tests\Feature\Commands;

use App\CsvParser;
use App\ValueObjects\Name;
use Tests\TestCase;

class ParseCsvTest extends TestCase
{
    /** @test */
    public function it_parses_a_file(): void
    {
        $this->mock(CsvParser::class)
            ->shouldReceive('parse')
            ->with(resource_path('csvs/examples.csv'))
            ->andReturn([new Name('Mr John Smith')])
            ->once();

        $this->artisan('names:parse', ['path' => 'examples.csv'])->expectsTable(['Name'], [
            ['Mr John Smith'],
        ]);
    }

    /** @test */
    public function it_parses_a_file_without_a_header(): void
    {
        $this->mock(CsvParser::class, function ($parser) {
            $parser->shouldReceive('withoutHeader')->once();

            $parser->shouldReceive('parse')
                ->with(resource_path('csvs/examples_without_header.csv'))
                ->andReturn([new Name('Mr John Smith')])
                ->once();
        });


        $this->artisan('names:parse', [
            'path' => 'examples_without_header.csv',
            '--without-header' => true,
        ])->expectsTable(['Name'], [
            ['Mr John Smith'],
        ]);
    }
}
