<?php
declare(strict_types=1);

use App\Domain\Service\GenerateCode;
use PHPUnit\Framework\TestCase;

class GenerateCodeTest extends TestCase
{
    private const MAX_LENGTH = 4;
    public function testLength()
    {
        $generateCode = new GenerateCode();
        for($i=0;$i<100;$i++){
            $code = $generateCode->handle();
            $this->assertEquals(self::MAX_LENGTH,strlen($code->value()));
        }
    }
}