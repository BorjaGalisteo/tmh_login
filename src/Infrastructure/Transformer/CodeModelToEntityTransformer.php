<?php
declare(strict_types=1);

namespace App\Infrastructure\Transformer;

use App\Domain\Entity\VerificationCode;
use App\Domain\ValueObject\CreatedAt;
use App\Domain\ValueObject\IsUsedCode;
use App\Domain\ValueObject\PhoneNumber;
use App\Infrastructure\Models\Code;
use App\Domain\ValueObject\Code as CodeEntity;

class CodeModelToEntityTransformer
{
    public function transform(Code $code)
    {
        return (new VerificationCode(
            new CodeEntity($code->getVerificationCode()),
            new PhoneNumber($code->getPhoneNumber()),
            new IsUsedCode($code->getUsed())
        ))->setCreatedAt(new CreatedAt($code->createdAt()->format('Y-m-d H:i:s.u')));
    }
}