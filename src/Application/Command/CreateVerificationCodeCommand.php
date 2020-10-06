<?php
declare(strict_types=1);
namespace App\Application\Command;

class CreateVerificationCodeCommand
{
    private int $phoneNumber;

    /**
     * CreateVerificationCodeCommand constructor.
     * @param int $phoneNumber
     */
    public function __construct(int $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return int
     */
    public function phoneNumber(): int
    {
        return $this->phoneNumber;
    }

}