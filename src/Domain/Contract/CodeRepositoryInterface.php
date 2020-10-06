<?php
declare(strict_types=1);
namespace App\Domain\Contract;

use App\Domain\Entity\VerificationCode;
use Exception;

interface CodeRepositoryInterface
{
    /**
     * @param VerificationCode $verificationCode
     * @throws Exception
     */
    public function create(VerificationCode $verificationCode): void;
}