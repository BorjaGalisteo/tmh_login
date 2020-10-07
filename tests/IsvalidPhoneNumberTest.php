<?php
declare(strict_types=1);

use App\Domain\Service\isValidPhoneNumber;
use App\Domain\Service\SanitizePhoneNumber;
use PHPUnit\Framework\TestCase;

class IsvalidPhoneNumberTest extends TestCase
{
    /**
     * @param array $params
     * @param array $expected
     * @dataProvider dataProvider
     */
    public function testPhoneNumber(array $params, array $expected)
    {
        $isValid = new isValidPhoneNumber(new SanitizePhoneNumber());
        $this->assertEquals($expected['is_valid'], $isValid->handle($params['number']));


    }

    public function dataProvider()
    {
        return [
            'happy path'   => [
                'params'   => [
                    'number' => '615359158',
                ],
                'expected' => [
                    'is_valid' => true,
                ],
            ],
            'prefix case'  => [
                'params'   => [
                    'number' => '+34615298765',
                ],
                'expected' => [
                    'is_valid' => true,
                ],
            ],
            'short number' => [
                'params'   => [
                    'number' => '61535',
                ],
                'expected' => [
                    'is_valid' => false,
                ],
            ],
            'long number'  => [
                'params'   => [
                    'number' => '9939393939399393993939393',
                ],
                'expected' => [
                    'is_valid' => false,
                ],
            ],
            'no number'    => [
                'params'   => [
                    'number' => 'a615298765',
                ],
                'expected' => [
                    'is_valid' => false,
                ],
            ],
        ];
    }
}