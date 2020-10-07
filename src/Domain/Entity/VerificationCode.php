<?php
declare(strict_types=1);
namespace App\Domain\Entity;


use App\Domain\ValueObject\Code;
use App\Domain\ValueObject\CreatedAt;
use App\Domain\ValueObject\IsUsedCode;
use App\Domain\ValueObject\PhoneNumber;

class VerificationCode
{
    private Code $code;
    private PhoneNumber $phoneNumber;
    private IsUsedCode $isUsedCode;
    private CreatedAt $createdAt;

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

    /**
     * @return CreatedAt|null
     */
    public function createdAt(): ?CreatedAt
    {
        return $this->createdAt;
    }

    /**
     * @param CreatedAt $createdAt
     * @return VerificationCode
     */
    public function setCreatedAt(CreatedAt $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }


}