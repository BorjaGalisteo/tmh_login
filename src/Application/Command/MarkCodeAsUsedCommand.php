<?php
declare(strict_types=1);
namespace App\Application\Command;

class MarkCodeAsUsedCommand
{
    private string $code;

    /**
     * MarkCodeAsUsedCommand constructor.
     * @param string $code
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

}