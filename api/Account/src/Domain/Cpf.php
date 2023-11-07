<?php

namespace Account\Domain;

use Exception;

class Cpf implements Document
{
    private string $value;

    /**
     * @throws Exception
     */
    public function __construct(string $cpf)
    {
        if(!$this->validate($cpf)) {
            throw new Exception("Invalid cpf");
        }
        $this->value = $cpf;
    }

    public function validate(string $cpf): bool
    {
        if (!$cpf) {
            return false;
        }
        $cpf = $this->clean($cpf);
        if($this->isInvalidLength($cpf)) {
            return false;
        }
        if($this->allDigitsTheSame($cpf)) {
            return false;
        }
        $firstDigit = $this->calculateDigit($cpf, 10);
        $secondDigit = $this->calculateDigit($cpf, 11);
        $checkDigit = $this->extractDigit($cpf);
        $calculatedDigit = "{$firstDigit}{$secondDigit}";
        return $checkDigit === $calculatedDigit;
    }

    public function clean(string $cpf): string
    {
        return preg_replace('/[^0-9]/','', $cpf);
    }

    public function isInvalidLength(string $cpf): bool
    {
        return strlen($cpf) !== 11;
    }

    public function allDigitsTheSame(string $cpf): false|int
    {
        /**
         * ^   => start of line (to be sure that the regex does not match just an internal substring)
         * (.) => get the first character of the string in backreference \1
         * \1* => next characters should be a repetition of the first
         * character (the captured \1)
         * $   => end of line (see start of line annotation)
         */
        return preg_match('/^(.)\1*$/u', $cpf);
    }

    public function calculateDigit(string $cpf, int $factor): int
    {
        $total = 0;
        for ($digitPosition = 0; $digitPosition < strlen($cpf); $digitPosition++) {
            if ($factor > 1) {
                $total += (int)substr($cpf, $digitPosition, 1) * $factor--;
            }
        }
        $rest = $total % 11;
        return $rest < 2 ? 0 : 11 - $rest;
    }

    public function extractDigit(string $cpf): string
    {
        return substr($cpf,strlen($cpf)-2,2);
    }

    public function getValue(): string
    {
        return $this->value;
    }
}