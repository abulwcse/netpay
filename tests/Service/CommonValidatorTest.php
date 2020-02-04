<?php

namespace App\Tests\Service;

use App\Service\CommonValidator;
use PHPUnit\Framework\TestCase;

class CommonValidatorTest extends TestCase
{

    /**
     * @var CommonValidator
     */
    private $validator;

    public function setUp()
    {
        $this->validator = new CommonValidator();
    }

    /**
     * @dataProvider emailTestProvider
     * @param $testCase
     * @param $expected
     */
    public function testIsEmail($testCase, $expected)
    {
        $this->assertEquals($expected, $this->validator->isEmail($testCase));
    }

    public function emailTestProvider()
    {
        return [
            ['foo', false],
            ['foo.com', false],
            ['https://foo', false],
            ['bar@foo.com', true],
            ['bar1@foo.com', true],
            ['bar-1@foo.com', true],
        ];
    }

    /**
     * @dataProvider alphaTestProvider
     * @param $testCase
     * @param $expected
     */
    public function testIsAlphabetic($testCase, $expected)
    {
        $this->assertEquals($expected, $this->validator->isAlphabetic($testCase));
    }

    public function alphaTestProvider()
    {
        return [
            ['foo', true],
            ['foo.com', false],
            ['https://foo', false],
            ['bar@foo.com', false],
            ['bar1foo.com', false],
            ['bar-1@foo.com', false],
            ['bar foo', true],
        ];
    }
    /**
     * @dataProvider numericTestProvider
     * @param $testCase
     * @param $expected
     */
    public function testIsNumber($testCase, $expected)
    {
        $this->assertEquals($expected, $this->validator->isNumber($testCase));
    }

    public function numericTestProvider()
    {
        return [
            ['foo', false],
            ['foo.com', false],
            ['https://foo', false],
            ['bar@foo.com', false],
            ['bar1foo.com', false],
            ['bar-1@foo.com', false],
            ['bar foo', false],
            [1, true],
            ["1", true],
            [12, true],
            ["12", true],
            ["12000000000", true],
        ];
    }
}
