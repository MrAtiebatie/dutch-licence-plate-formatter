<?php

namespace Tests;

use Juukie\DutchLicencePlateFormatter;
use PHPUnit\Framework\TestCase;

class DutchLicencePlateFormatterTest extends TestCase
{
    /**
     * @test
     * @dataProvider licensePlates
     */
    public function it_can_format_correctly($input, $output)
    {
        $this->assertSame($output, DutchLicencePlateFormatter::format($input));
    }

    /**
     * @return array
     */
    public function licensePlates()
    {
        return [
            ['XX9999', 'XX-99-99'],
            ['9999XX', '99-99-XX'],
            ['XX99XX', 'XX-99-XX'],
            ['XXXX99', 'XX-XX-99'],
            ['99XXXX', '99-XX-XX'],
            ['99XXX9', '99-XXX-9'],
            ['9XXX99', '9-XXX-99'],
            ['XX999X', 'XX-999-X'],
            ['X999XX', 'X-999-XX'],
            ['XXX99X', 'XXX-99-X'],
            ['X99XXX', 'X-99-XXX'],
            ['9XX999', '9-XX-999'],
            ['999XX9', '999-XX-9'],
            ['999-xx-9', '999-XX-9'],
            ['999_xX_9', '999-XX-9'],
            ['CDB1', 'CDB1'],
            ['CDJ45', 'CDJ45'],
            ['fooBar', 'FOOBAR'],
        ];
    }
}
