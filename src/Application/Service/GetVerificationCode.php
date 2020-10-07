<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Command\GetVerificationCodeCommand;
use App\Domain\Contract\CodeRepositoryInterface;
use App\Domain\Entity\VerificationCode;
use App\Domain\ValueObject\CodeId;
use App\Infrastructure\Exception\CodeException;
use App\Infrastructure\Exception\CodeNotFoundException;

class GetVerificationCode
{
    private CodeRepositoryInterface $codeRepository;

    /**
     * GetVerificationCode constructor.
     * @param CodeRepositoryInterface $codeRepository
     */
    public function __construct(CodeRepositoryInterface $codeRepository)
    {
        $this->codeRepository = $codeRepository;
    }

    /**
     * @param GetVerificationCodeCommand $command
     * @return VerificationCode
     * @throws CodeException
     * @throws CodeNotFoundException
     */
    public function handle(GetVerificationCodeCommand $command): VerificationCode
    {
        return $this->codeRepository->get(new CodeId($command->codeId()));
    }
}