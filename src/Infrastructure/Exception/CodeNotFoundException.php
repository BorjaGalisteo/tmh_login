<?php
declare(strict_types=1);
namespace App\Infrastructure\Exception;

use Exception;

class CodeNotFoundException extends Exception
{
    /**
     * @param string $message
     * @return CodeNotFoundException
     */
    public static function becauseOf(string $message): self
    {
        return new self($message);
    }
}