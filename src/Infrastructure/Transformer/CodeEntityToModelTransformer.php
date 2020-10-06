<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer;


use App\Domain\Entity\VerificationCode;
use App\Infrastructure\Models\Code;

class CodeEntityToModelTransformer
{
    public function transform(VerificationCode $verificationCode): Code
    {
        $code = new Code();
        $code->setPhoneNumber($verificationCode->phoneNumber()->value());
        $code->setUsed($verificationCode->isUsedCode()->value());
        $code->setVerificationCode($verificationCode->code()->value());

        return $code;
    }
}