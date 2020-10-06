<?php
declare(strict_types=1);
namespace App\Domain\ValueObject;

class PhoneNumber
{
    public const MAX_LENGTH = 13;
    public const MIN_LENGTH = 9;

    private int $phone_number;

    /**
     * PhoneNumber constructor.
     * @param int $phone_number
     */
    public function __construct(int $phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->phone_number;
    }

}