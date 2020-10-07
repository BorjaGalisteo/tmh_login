<?php
declare(strict_types=1);

use App\Domain\Service\IsAdminCode;
use App\Domain\ValueObject\Code;
use PHPUnit\Framework\TestCase;

class AdminCodeTest extends TestCase
{
    /**
     * @param array $params
     * @param array $expected
     * @dataProvider dataprovider
     */
    public function testAdmin(array $params, array $expected)
    {
        $service  = new IsAdminCode();
        $response = $service->handle(new Code($params['code']));
        $this->assertEquals($expected['result'], $response);
    }

    public function dataprovider()
    {
        return [
            'false case' => [
                'params'   => [
                    'code' => 'ACB9',
                ],
                'expected' => [
                    'result' => false,
                ],
            ],
            'true case'  => [
                'params'   => [
                    'code' => '0000',
                ],
                'expected' => [
                    'result' => true,
                ],
            ],
        ];
    }
}