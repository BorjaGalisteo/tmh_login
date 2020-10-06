<?php
declare(strict_types=1);

namespace App\Domain\ValueObject;

class IsUsedCode
{
    public const IS_USED_DEFAULT = false;
    private bool $used;

    /**
     * IsUsedCode constructor.
     * @param bool $used
     */
    public function __construct(bool $used)
    {
        $this->used = $used;
    }

    /**
     * @return bool
     */
    public function value(): bool
    {
        return $this->used;
    }
}