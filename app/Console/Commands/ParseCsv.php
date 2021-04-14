<?php

namespace App\Console\Commands;

use App\CsvParser;
use Illuminate\Console\Command;

class ParseCsv extends Command
{
    protected $signature = 'names:parse
                            {path : The path of the CSV file to parse}
                            {--without-header}';

    protected $description = 'Parse a CSV file from the resources directory into a list of names.';

    private CsvParser $csvParser;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CsvParser $csvParser)
    {
        parent::__construct();

        $this->csvParser = $csvParser;
    }

    public function handle()
    {
        if ($this->option('without-header')) {
            $this->csvParser->withoutHeader();
        }

        $names = $this->csvParser->parse(
            resource_path("csvs/{$this->argument('path')}")
        );

        $this->table(
            ['Name'],
            array_map(fn ($name) => [(string) $name], $names)
        );
    }
}
