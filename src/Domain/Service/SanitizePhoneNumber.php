<?php
declare(strict_types=1);
namespace App\Domain\Service;

class SanitizePhoneNumber
{
    private string $phone_number;

    public function sanitize(string $phone_number): string
    {
        $this->phone_number = $phone_number;
        $this->replacePlus();
        $this->replaceEmptySpaces();

        return $this->phone_number;
    }

    private function replacePlus()
    {
        $this->phone_number = str_replace('+', 00, $this->phone_number);
    }

    private function replaceEmptySpaces()
    {
        $this->phone_number = str_replace(' ', '', $this->phone_number);
    }
}