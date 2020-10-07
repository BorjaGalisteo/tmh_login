<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\CheckVerificationCodeCommand;
use App\Domain\Contract\CodeRepositoryInterface;
use App\Domain\Service\CheckCode;
use App\Domain\Service\IsAdminCode;
use App\Domain\ValueObject\Code;
use App\Domain\ValueObject\PhoneNumber;
use App\Domain\ValueObject\RightCode;
use App\Infrastructure\Exception\CodeException;
use App\Infrastructure\Exception\CodeNotFoundException;

class CheckVerificationCode
{
    private CodeRepositoryInterface $codeRepository;
    private CheckCode $checkCode;
    /** @var IsAdminCode */
    private $isAdminCode;

    /**
     * checkVerificationCode constructor.
     * @param CodeRepositoryInterface $codeRepository
     * @param CheckCode $checkCode
     * @param IsAdminCode $isAdminCode
     */
    public function __construct(CodeRepositoryInterface $codeRepository, CheckCode $checkCode, IsAdminCode $isAdminCode)
    {
        $this->codeRepository = $codeRepository;
        $this->checkCode      = $checkCode;
        $this->isAdminCode    = $isAdminCode;
    }

    /**
     * @param CheckVerificationCodeCommand $command
     * @return RightCode
     * @throws CodeException
     * @throws CodeNotFoundException
     */
    public function handle(CheckVerificationCodeCommand $command): RightCode
    {
        $code = new Code($command->code());
        if ($this->isAdminCode->handle($code)) {
            return new RightCode(true);
        }
        $verificationCode = $this->codeRepository->getByCodeAndTelephone(
            $code,
            new PhoneNumber($command->phone_number())
        );

        return $this->checkCode->handle($verificationCode, $code);
    }

}