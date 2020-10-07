<?php
declare(strict_types=1);
namespace App\Infrastructure\Exception;


class CodeException extends \Exception
{
    /**
     * @param string $message
     * @return CodeException
     */
    public static function becauseOf(string $message): self
    {
        return new self($message);
    }
}