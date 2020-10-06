<?php
declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\ValueObject\Code;

class GenerateCode
{
    public function handle()
    {
        $bytes = random_bytes(2);
        return new Code(bin2hex($bytes));
    }
}