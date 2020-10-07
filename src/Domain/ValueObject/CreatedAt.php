<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

class CreatedAt
{
    private string $date;

    /**
     * CreatedAt constructor.
     * @param string $date
     */
    public function __construct(string $date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->date;
    }
}