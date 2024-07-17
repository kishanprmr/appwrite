<?php

namespace Appwrite\Auth\Validator;

use Utopia\Http\Validator;

/**
 * MockNumber.
 *
 * Validates if a given object represents a valid phone and OTP pair
 */
class MockNumber extends Validator
{
    private $message = '';

    /**
     * Get Description.
     *
     * Returns validator description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->message;
    }

    /**
     * Is valid.
     *
     * @param mixed $value
     *
     * @return bool
     */
    public function isValid($value): bool
    {
        if (!\is_array($value) || !isset($value['phone']) || !isset($value['otp'])) {
            $this->message = 'Invalid payload structure. Please check the "phone" and "otp" fields';
            return false;
        }

        $phone = new Phone();
        if (!$phone->isValid($value['phone'])) {
            $this->message = $phone->getDescription();
            return false;
        }

        $otp = new Validator\Text(6, 6);
        if (!$otp->isValid($value['otp'])) {
            $this->message = 'OTP must be a valid string and exactly 6 characters.';
            return false;
        }

        return true;
    }

    /**
     * Is array
     *
     * Function will return true if object is array.
     *
     * @return bool
     */
    public function isArray(): bool
    {
        return false;
    }

    /**
     * Get Type
     *
     * Returns validator type.
     *
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE_OBJECT;
    }
}
