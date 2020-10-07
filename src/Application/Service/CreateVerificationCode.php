<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\CreateVerificationCodeCommand;
use \App\Domain\Contract\CodeRepositoryInterface;
use App\Domain\Entity\VerificationCode;
use App\Domain\Service\GenerateCode;
use App\Domain\ValueObject\Code;
use App\Domain\ValueObject\CodeId;
use App\Domain\ValueObject\IsUsedCode;
use App\Domain\ValueObject\PhoneNumber;
use Exception;

class CreateVerificationCode
{
    private CodeRepositoryInterface $codeRepository;
    /** @var GenerateCode */
    private $generateCode;

    /**
     * CreateVerificationCode constructor.
     * @param CodeRepositoryInterface $codeRepository
     * @param GenerateCode $generateCode
     */
    public function __construct(CodeRepositoryInterface $codeRepository, GenerateCode $generateCode)
    {
        $this->codeRepository = $codeRepository;
        $this->generateCode = $generateCode;
    }

    /**
     * @param CreateVerificationCodeCommand $command
     * @return CodeId
     * @throws Exception
     */
    public function handle(CreateVerificationCodeCommand $command): CodeId
    {
        return $this->codeRepository->create(
            new VerificationCode(
                $this->generateCode->handle(),
                new PhoneNumber($command->phoneNumber()),
                new IsUsedCode(IsUsedCode::IS_USED_DEFAULT)
            ));
    }


}