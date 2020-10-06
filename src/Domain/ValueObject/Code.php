<?php
declare(strict_types=1);
namespace App\Domain\ValueObject;

class Code
{
    private string $code;

    /**
     * VerificationCode constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->code;
    }
}