<?php
declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\ValueObject\Code;

class IsAdminCode
{
    private const ADMIN_CODE = '0000';

    public function handle(Code $code): bool
    {
        return self::ADMIN_CODE === $code->value();
    }
}