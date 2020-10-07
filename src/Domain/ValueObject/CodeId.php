<?php
declare(strict_types=1);
namespace App\Domain\ValueObject;

class CodeId
{
    private int $id;

    /**
     * CodeId constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->id;
    }
}