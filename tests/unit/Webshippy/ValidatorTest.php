<?php

namespace unit\Webshippy;

use PHPUnit\Framework\TestCase;
use Webshippy\Validator;

/**
 * Test for validator class
 *
 * @covers \Webshippy\Validator
 */
class ValidatorTest extends TestCase
{
    /**
     * Data provider for valid test cases
     *
     * @return array
     */
    public function validProvider(): array
    {
        return [
            'valid test case 1' => [2, ['index.php', '{"1":2}']],
            'valid test case 2' => [2, ['index.php', '{"3":2, "boolean": true}']],
            'valid test case 3' => [2, ['index.php', '{"3":"2","hello":"world"}']],
        ];
    }

    /**
     * Data provider for invalid test cases
     *
     * @return array
     */
    public function invalidProvider(): array
    {
        return [
            'invalid test case 1' => [1, ['index.php', ['']]],
            'invalid test case 2' => [1, ['i.php', ['hello world']]],
            'invalid test case 3' => [2, ['a.php', ['{"{}']]],
            'invalid test case 4' => [2, ['b.php', [true]]],
            'invalid test case 5' => [2, ['index.php', [false]]],
            'invalid test case 6' => [2, ['', [14]]],
            'invalid test case 7' => [2, ['', [null]]],
        ];
    }

    /**
     * Test for Validator::validate() method
     *
     * @dataProvider validProvider data provider for test
     * @param int $argc number of input arguments
     * @param array $argv input arguments
     * @return void
     */
    public function testValidateWithValidData(int $argc, array $argv): void
    {
        $validator = new Validator($argc, $argv);
        $this->assertTrue($validator->validate());
    }

    /**
     * Test for Validator::getError() method
     *
     * @return void
     */
    public function testGetError(): void
    {
        $validator = new Validator(2, ['index.php', 'hello world']);
        $validator->validate();
        $this->assertEquals('Invalid json!', $validator->getError());

        $validator = new Validator(3, ['index.php', 'hello world', 'third parameter']);
        $validator->validate();
        $this->assertEquals('Ambiguous number of parameters!', $validator->getError());
    }
}
