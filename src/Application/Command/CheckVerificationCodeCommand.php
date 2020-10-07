<?php
declare(strict_types=1);

namespace App\Application\Command;

class CheckVerificationCodeCommand
{
    private int $phone_number;
    private string $code;

    /**
     * CheckVerificationCodeCommand constructor.
     * @param int $phone_number
     * @param string $code
     */
    public function __construct(int $phone_number, string $code)
    {
        $this->phone_number = $phone_number;
        $this->code         = $code;
    }

    /**
     * @return int
     */
    public function phone_number(): int
    {
        return $this->phone_number;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

}