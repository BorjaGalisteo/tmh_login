<?php
declare(strict_types=1);

namespace App\Application\Command;

class GetVerificationCodeCommand
{
    private int $code_id;

    /**
     * GetVerificationCodeCommand constructor.
     * @param int $code_id
     */
    public function __construct(int $code_id)
    {
        $this->code_id = $code_id;
    }

    /**
     * @return int
     */
    public function codeId(): int
    {
        return $this->code_id;
    }



}