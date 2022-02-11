<?php

namespace unit\Webshippy;

use PHPUnit\Framework\TestCase;
use Webshippy\Formatter;

/**
 * Test for Formatter class
 *
 * @covers \Webshippy\Formatter
 * @covers \Webshippy\Priority
 */
class FormatterTest extends TestCase
{
    /**
     * Data provider with valid data for getResult test
     *
     * @return array data provider
     */
    public function dataProvider(): array
    {
        return [
            'valid test case 1' => [['hello', 'world'], ['hello', 'world'], [
                [
                    'hello               ',
                    'world               ',
                ],
                [
                    '====================',
                    '====================',
                ],
            ]],
            'valid test case 2' => [['hello', 'world'], ['hello', ['world']], [
                [
                    'hello               ',
                    'world               ',
                ],
                [
                    '====================',
                    '====================',
                ],
                [
                    'world               ',
                ],
            ]],
            'valid test case 3' => [
                [
                    'product_id',
                    'quantity',
                    'priority',
                    'created_at',
                ],
                [
                    [
                        'product_id' => 3,
                        'quantity' => 5,
                        'priority' => 3,
                        'created_at' => '2021-03-23 05:01:29',
                    ],
                    [
                        'product_id' => 1,
                        'quantity' => 2,
                        'priority' => 3,
                        'created_at' => '2021-03-25 14:51:47',
                    ],
                    [
                        'product_id' => 2,
                        'quantity' => 1,
                        'priority' => 2,
                        'created_at' => '2021-03-21 14:00:26',
                    ],
                    [
                        'product_id' => 3,
                        'quantity' => 1,
                        'priority' => 2,
                        'created_at' => '2021-03-22 12:31:54',
                    ],
                    [
                        'product_id' => 1,
                        'quantity' => 6,
                        'priority' => 1,
                        'created_at' => '2021-03-21 06:17:20',
                    ],
                    [
                        'product_id' => 2,
                        'quantity' => 4,
                        'priority' => 1,
                        'created_at' => '2021-03-22 17:41:32',
                    ],
                    [
                        'product_id' => 2,
                        'quantity' => 2,
                        'priority' => 1,
                        'created_at' => '2021-03-24 11:02:06',
                    ],
                    [
                        'product_id' => 3,
                        'quantity' => 2,
                        'priority' => 1,
                        'created_at' => '2021-03-24 12:39:58',
                    ],
                    [
                        'product_id' => 1,
                        'quantity' => 1,
                        'priority' => 1,
                        'created_at' => '2021-03-25 19:08:22',
                    ],
                ],
                [
                    [
                        'product_id          ',
                        'quantity            ',
                        'priority            ',
                        'created_at          ',
                    ],
                    [
                        '====================',
                        '====================',
                        '====================',
                        '====================',
                    ],
                    [
                        '3                   ',
                        '5                   ',
                        'high                ',
                        '2021-03-23 05:01:29 ',
                    ],
                    [
                        '1                   ',
                        '2                   ',
                        'high                ',
                        '2021-03-25 14:51:47 ',
                    ],
                    [
                        '2                   ',
                        '1                   ',
                        'medium              ',
                        '2021-03-21 14:00:26 ',
                    ],
                    [
                        '3                   ',
                        '1                   ',
                        'medium              ',
                        '2021-03-22 12:31:54 ',
                    ],
                    [
                        '1                   ',
                        '6                   ',
                        'low                 ',
                        '2021-03-21 06:17:20 ',
                    ],
                    [
                        '2                   ',
                        '4                   ',
                        'low                 ',
                        '2021-03-22 17:41:32 ',
                    ],
                    [
                        '2                   ',
                        '2                   ',
                        'low                 ',
                        '2021-03-24 11:02:06 ',
                    ],
                    [
                        '3                   ',
                        '2                   ',
                        'low                 ',
                        '2021-03-24 12:39:58 ',
                    ],
                    [
                        '1                   ',
                        '1                   ',
                        'low                 ',
                        '2021-03-25 19:08:22 ',
                    ],
                ],
            ],
            'valid test case 4' => [
                [
                    'product_id',
                    'quantity',
                    'priority',
                    'created_at',
                ],
                [
                    [
                        'product_id' => 1,
                        'quantity' => 2,
                        'priority' => 3,
                        'created_at' => '2021-03-25 14:51:47',
                    ],
                    [
                        'product_id' => 2,
                        'quantity' => 1,
                        'priority' => 2,
                        'created_at' => '2021-03-21 14:00:26',
                    ],
                    [
                        'product_id' => 3,
                        'quantity' => 1,
                        'priority' => 2,
                        'created_at' => '2021-03-22 12:31:54',
                    ],
                    [
                        'product_id' => 2,
                        'quantity' => 2,
                        'priority' => 1,
                        'created_at' => '2021-03-24 11:02:06',
                    ],
                    [
                        'product_id' => 1,
                        'quantity' => 1,
                        'priority' => 1,
                        'created_at' => '2021-03-25 19:08:22',
                    ],
                ],
                [
                    [
                        'product_id          ',
                        'quantity            ',
                        'priority            ',
                        'created_at          ',
                    ],
                    [
                        '====================',
                        '====================',
                        '====================',
                        '====================',
                    ],
                    [
                        '1                   ',
                        '2                   ',
                        'high                ',
                        '2021-03-25 14:51:47 ',
                    ],
                    [
                        '2                   ',
                        '1                   ',
                        'medium              ',
                        '2021-03-21 14:00:26 ',
                    ],
                    [
                        '3                   ',
                        '1                   ',
                        'medium              ',
                        '2021-03-22 12:31:54 ',
                    ],
                    [
                        '2                   ',
                        '2                   ',
                        'low                 ',
                        '2021-03-24 11:02:06 ',
                    ],
                    [
                        '1                   ',
                        '1                   ',
                        'low                 ',
                        '2021-03-25 19:08:22 ',
                    ],
                ],
            ],
        ];
    }

    /**
     * Tests for Formatter::format() method
     *
     * @dataProvider dataProvider data provider for test
     * @doesNotPerformAssertions
     * @param array $header csv head
     * @param array $body csv body
     * @return void
     */
    public function testFormat(array $header, array $body): void
    {
        $formatter = new Formatter($header, $body);
        $formatter->format();
    }

    /**
     * Tests for Formatter::getResult() method
     *
     * @dataProvider dataProvider data provider for test
     * @param array $header csv header
     * @param array $body csv body
     * @param array $except excepted test result
     * @return void
     */
    public function testGetResult(array $header, array $body, array $except)
    {
        $formatter = new Formatter($header, $body);
        $formatter->format();
        $this->assertEquals($except, $formatter->getResult());
    }
}
