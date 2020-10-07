<?php
declare(strict_types=1);

use App\Application\Command\GetVerificationCodeCommand;
use App\Application\Service\CreateVerificationCode;
use App\Application\Service\GetVerificationCode;
use App\Domain\Entity\VerificationCode;
use App\Domain\Service\GenerateCode;
use App\Domain\ValueObject\Code;
use App\Domain\ValueObject\CodeId;
use App\Domain\ValueObject\IsUsedCode;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\Exception\CodeException;
use App\Infrastructure\Exception\CodeNotFoundException;
use App\Infrastructure\Repository\MySqliCodeRepository;
use PHPUnit\Framework\TestCase;
use Mockery as m;
use App\Application\Command\CreateVerificationCodeCommand;

class CreateCodeTest extends TestCase
{
    /**
     * @param array $params
     * @param array $expected
     * @throws CodeException
     * @throws CodeNotFoundException
     * @dataProvider dataprovider
     */
    public function testCreation(array $params, array $expected)
    {
        // Mocking dependencies. And Test that the parameters recieved are right.
        $codeRepository = m::mock(MySqliCodeRepository::class);
        $codeRepository->shouldReceive('create')
            ->andReturnUsing(function (VerificationCode $verificationCode) use ($params, $expected) {
                $this->assertEquals($expected['verification_code'], $verificationCode->code()->value());
                $this->assertEquals($expected['phone'], $verificationCode->phoneNumber()->value());

                return new CodeId($params['code_id']);
            });
        $generateCode = m::mock(GenerateCode::class);
        $generateCode->shouldReceive('handle')
            ->andReturnUsing(function () use ($params) {
                return new Code($params['verification_code']);
            });

        $createVerificationCode = new CreateVerificationCode($codeRepository, $generateCode);
        $verificationCodeId     = $createVerificationCode->handle(new CreateVerificationCodeCommand($params['phone']));

        // Mocking dependencies. And Test that the parameters recieved are right.
        $codeRepository->shouldReceive('get')
            ->andReturnUsing(function (CodeId $codeId) use ($params, $expected) {
                $this->assertEquals($expected['code_id'], $codeId->value());

                return new VerificationCode(
                    new Code($params['verification_code']), new PhoneNumber($params['phone']),
                    new IsUsedCode(IsUsedCode::IS_USED_DEFAULT)
                );
            });

        $getCode          = new GetVerificationCode($codeRepository);
        $verificationCode = $getCode->handle(new GetVerificationCodeCommand($verificationCodeId->value()));

        //Test if what we've got is right based on the params.
        $this->assertEquals($expected['verification_code'], $verificationCode->code()->value());
        $this->assertEquals($expected['phone'], $verificationCode->phoneNumber()->value());
    }

    public function dataprovider()
    {
        return [
            'base case' => [
                'params'   => [
                    'phone'             => 615359438,
                    'code_id'           => 1,
                    'verification_code' => 'a1b2',
                ],
                'expected' => [
                    'phone'             => 615359438,
                    'code_id'           => 1,
                    'verification_code' => 'a1b2',
                ],
            ],
        ];
    }
}