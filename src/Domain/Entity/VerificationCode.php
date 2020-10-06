<?php
declare(strict_types=1);
namespace App\Domain\Entity;


use App\Domain\ValueObject\Code;
use App\Domain\ValueObject\IsUsedCode;
use App\Domain\ValueObject\PhoneNumber;

class VerificationCode
{
    private Code $code;
    private PhoneNumber $phoneNumber;
    private IsUsedCode $isUsedCode;

    /**
     * VerificationCode constructor.
     * @param Code $code
     * @param PhoneNumber $phoneNumber
     * @param IsUsedCode $isUsedCode
     */
    public function __construct(Code $code, PhoneNumber $phoneNumber, IsUsedCode $isUsedCode)
    {
        $this->code        = $code;
        $this->phoneNumber = $phoneNumber;
        $this->isUsedCode  = $isUsedCode;
    }

    /**
     * @return Code
     */
    public function code(): Code
    {
        return $this->code;
    }

    /**
     * @return PhoneNumber
     */
    public function phoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    /**
     * @return IsUsedCode
     */
    public function isUsedCode(): IsUsedCode
    {
        return $this->isUsedCode;
    }
}