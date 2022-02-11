<?php

namespace unit\Webshippy;

use League\Csv\SyntaxError;
use PHPUnit\Framework\TestCase;
use Webshippy\FulfillableOrderService;

/**
 * Test for FulFillableOrderService class
 *
 * @covers \Webshippy\FulfillableOrderService
 * @covers \Webshippy\Validator
 * @covers \Webshippy\Formatter
 * @covers \Webshippy\Priority
 */
class FulfillableOrderServiceTest extends TestCase
{
    /**
     * csv file with original content
     */
    private const CSV_FILE = 'tests/files/orders.csv';

    /**
     * Data provider that contains valid test cases
     *
     * @return array data provider
     */
    public function validTestCaseProvider(): array
    {
        return [
            'valid test case 1' => [2, ['index.php', '{"1":8,"2":4,"3":5}'], static::CSV_FILE],
            'valid test case 2' => [2, ['index.php', '{"1":2,"2":3,"3":1}'], static::CSV_FILE],
            'valid test case 3' => [2, ['index.php', '{"942":123}'], static::CSV_FILE],
            'valid test case 4' => [2, ['index.php', '{"boolean":false}'], static::CSV_FILE],
            'valid test case 5' => [2, ['index.php', '{"string":"string"}'], static::CSV_FILE],
            'valid test case 6' => [2, ['index.php', '{"1":0}'], static::CSV_FILE],
            'valid test case 7' => [2, ['index.php', '{"1":0}'], 'tests/files/orders2.csv'],
            'valid test case 8' => [2, ['index.php', '{"1":0}'], 'tests/files/orders3.csv'],
            'valid test case 9' => [2, ['index.php', '{"1":0}'], 'tests/files/orders4.csv'],
            'valid test case 10' => [2, ['index.php', '{"1":0}'], 'tests/files/orders5.csv'],
        ];
    }

    /**
     * Data provider that contains invalid test cases
     *
     * @return array data provider
     */
    public function invalidTestCaseProvider(): array
    {
        return [
            'invalid test case 1' => [2, ['index.php', ''], static::CSV_FILE],
            'invalid test case 2' => [2, ['index.php', 'string'], static::CSV_FILE],
            'invalid test case 3' => [2, ['index.php', false], static::CSV_FILE],
            'invalid test case 4' => [1, ['index.php', 'hello world!'], static::CSV_FILE],
            'invalid test case 5' => [2, ['index.php', '{"1":0}'], 'tests/files/orders6.csv'],
            'invalid test case 6' => [2, ['index.php', [true]], static::CSV_FILE],
            'invalid test case 7' => [2, ['ind.php', [123]], static::CSV_FILE],
            'invalid test case 8' => [3, ['index.php', [false, 'third parameter']], static::CSV_FILE],
            'invalid test case 9' => [1, ['index.php', ['hello world!']], static::CSV_FILE],
        ];
    }

    /**
     * Test for FulfillableOrderService::execute() method
     *
     * @dataProvider validTestCaseProvider data provider for test
     * @param int $argc number of input arguments
     * @param array $argv input arguments
     * @param string $csvFile csv file
     * @throws SyntaxError when csv syntax is invalid
     * @return void
     */
    public function testExecuteWithValidTestCase(int $argc, array $argv, string $csvFile): void
    {
        $fulfillmentOrderService = new FulfillableOrderService($argc, $argv, $csvFile);
        $result = $fulfillmentOrderService->execute();
        $this->assertTrue($result);
    }

    /**
     * Test for FulfillableOrderService::execute() method
     *
     * @dataProvider invalidTestCaseProvider data provider for test
     * @param int $argc number of input arguments
     * @param array $argv input arguments
     * @param string $csvFile csv file
     * @throws SyntaxError when csv syntax is invalid
     * @return void
     */
    public function testExecuteWithInvalidTestCase(int $argc, array $argv, string $csvFile): void
    {
        $fulfillmentOrderService = new FulfillableOrderService($argc, $argv, $csvFile);
        $this->assertFalse($fulfillmentOrderService->execute());
    }
}
