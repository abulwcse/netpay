<?php


namespace App\Service;


class CommonValidator
{

    public function isAlphabetic($text)
    {
        return $this->validate('/^[a-zA-Z\s]+$/', $text);
    }

    public function isNumber(string $text)
    {
        return is_numeric($text);
    }

    public function isEmail(string $text)
    {
        return filter_var($text, FILTER_VALIDATE_EMAIL) !== false;

    }

    private function validate(string $pattern, string $string)
    {
        if (preg_match($pattern, $string)) {
            return true;
        }
        return false;
    }
}
