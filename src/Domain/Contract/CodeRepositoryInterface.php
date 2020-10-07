<?php
declare(strict_types=1);
namespace App\Domain\Contract;

use App\Domain\Entity\VerificationCode;
use App\Domain\ValueObject\CodeId;
use App\Infrastructure\Exception\CodeException;
use App\Infrastructure\Exception\CodeNotFoundException;
use Exception;

interface CodeRepositoryInterface
{
    /**
     * @param VerificationCode $verificationCode
     * @return CodeId
     * @throws Exception
     */
    public function create(VerificationCode $verificationCode): CodeId;

    /**
     * @param CodeId $codeId
     * @return VerificationCode
     * @throws CodeException
     * @throws CodeNotFoundException
     */
    public function get(CodeId $codeId): VerificationCode;
}