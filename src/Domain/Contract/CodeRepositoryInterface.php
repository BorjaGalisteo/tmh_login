<?php
declare(strict_types=1);
namespace App\Domain\Contract;

use App\Domain\Entity\VerificationCode;
use App\Domain\ValueObject\Code as CodeDomain;
use App\Domain\ValueObject\CodeId;
use App\Domain\ValueObject\PhoneNumber;
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

    /**
     * @param CodeDomain $code
     * @param PhoneNumber $phoneNumber
     * @return VerificationCode
     * @throws CodeException
     * @throws CodeNotFoundException
     */
    public function getByCodeAndTelephone(CodeDomain $code, PhoneNumber $phoneNumber): VerificationCode;

    /**
     * @param CodeDomain $code
     */
    public function setAsUsed(CodeDomain $code): void;
}