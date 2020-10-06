<?php
declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\ValueObject\PhoneNumber;

class isValidPhoneNumber
{
    private string $phone_number;
    private SanitizePhoneNumber $sanitizePhoneNumber;

    /**
     * isValidPhoneNumber constructor.
     * @param SanitizePhoneNumber $sanitizePhoneNumber
     */
    public function __construct(SanitizePhoneNumber $sanitizePhoneNumber)
    {
        $this->sanitizePhoneNumber = $sanitizePhoneNumber;
    }

    public function handle(string $phoneNumber)
    {
        $this->phone_number = $this->sanitizePhoneNumber->sanitize($phoneNumber);
        if ($this->check()) {
            return true;
        }
        return false;
    }

    private function check()
    {
        return $this->hasRightLength() && is_numeric($this->phone_number);
    }

    private function hasRightLength(): bool
    {
        if (strlen($this->phone_number) >= PhoneNumber::MIN_LENGTH && strlen($this->phone_number) <= PhoneNumber::MAX_LENGTH) {
            return true;
        }
        return false;
    }
}