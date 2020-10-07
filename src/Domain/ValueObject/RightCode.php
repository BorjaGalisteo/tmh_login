<?php
declare(strict_types=1);
namespace App\Domain\ValueObject;


class RightCode
{
    private bool $right;

    /**
     * RightCode constructor.
     * @param bool $right
     */
    public function __construct(bool $right)
    {
        $this->right = $right;
    }

    /**
     * @return bool
     */
    public function right(): bool
    {
        return $this->right;
    }
}