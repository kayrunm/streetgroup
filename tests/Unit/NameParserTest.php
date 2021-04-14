<?php

namespace Tests\Unit;

use App\NameParser;
use PHPUnit\Framework\TestCase;

class NameParserTest extends TestCase
{
    /** @test */
    public function it_instantiates_the_class(): void
    {
        $object = new NameParser('Mr Joe Bloggs');

        $this->assertInstanceOf(NameParser::class, $object);
    }

    /** @test */
    public function it_parses_a_single_name_with_a_title_and_last_name(): void
    {
        $object = new NameParser('Mr Smith');

        $result = $object->parse();

        $this->assertIsArray($result);
        $this->assertEquals([
            'title' => 'Mr',
            'first_name' => null,
            'initial' => null,
            'last_name' => 'Smith',
        ], $result);
    }

    /** @test */
    public function it_parses_a_single_name_with_a_title_and_first_name_and_last_name(): void
    {
        $object = new NameParser('Mr John Smith');

        $result = $object->parse();

        $this->assertIsArray($result);
        $this->assertEquals([
            'title' => 'Mr',
            'first_name' => 'John',
            'initial' => null,
            'last_name' => 'Smith',
        ], $result);
    }

    /** @test */
    public function it_parses_a_single_name_with_a_title_and_initial_and_last_name(): void
    {
        $object = new NameParser('Mr M Mackie');

        $result = $object->parse();

        $this->assertIsArray($result);
        $this->assertEquals([
            'title' => 'Mr',
            'first_name' => null,
            'initial' => 'M',
            'last_name' => 'Mackie',
        ], $result);
    }

    /** @test */
    public function it_parses_a_single_name_with_a_title_and_initial_and_last_name_with_a_full_stop_in_the_initial(): void
    {
        $object = new NameParser('Mr F. Fredrickson');

        $result = $object->parse();

        $this->assertIsArray($result);
        $this->assertEquals([
            'title' => 'Mr',
            'first_name' => null,
            'initial' => 'F',
            'last_name' => 'Fredrickson',
        ], $result);
    }
}
