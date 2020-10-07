<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer;

use App\Domain\Entity\VerificationCode;

class VerificationCodeToArrayTransformer
{
    public function transform(VerificationCode $verificationCode): array
    {
        return [
            'verification_code' => $verificationCode->code()->value(),
            'phone_number' => $verificationCode->phoneNumber()->value(),
            'used' => $verificationCode->isUsedCode()->value(),
        ];
    }
}