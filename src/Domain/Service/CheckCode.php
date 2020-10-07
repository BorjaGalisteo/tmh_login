<?php
declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Entity\VerificationCode;
use App\Domain\ValueObject\Code;
use App\Domain\ValueObject\CreatedAt;
use App\Domain\ValueObject\RightCode;
use Carbon\Carbon;

class CheckCode
{
    private const EXPIRATION_MINUTES = 5;

    public function handle(VerificationCode $verificationCode, Code $code): RightCode
    {

        if (!$verificationCode->isUsedCode()->value() && !$this->isExpired($verificationCode->createdAt())) {
            return new RightCode($verificationCode->code()->value() == $code->value());
        }

        return new RightCode(false);
    }

    private function isExpired(CreatedAt $createdAt): bool
    {
        $dateCreated = Carbon::parse($createdAt->value());
        $diff        = $dateCreated->diffInMinutes(Carbon::now());
        return $diff > self::EXPIRATION_MINUTES;
    }


}