<?php

namespace Account\Domain;

use Exception;

class Cnpj implements Document
{
    private string $value;

    /**
     * @throws Exception
     */
    public function __construct(string $cnpj)
    {
        if(!$this->validate($cnpj)) {
            throw new Exception("Invalid cnpj");
        }
        $this->value = $cnpj;
    }

    /**
     * @throws Exception
     */
    public function validate(string $cnpj): bool
    {
        if(empty($cnpj)) {
            throw new Exception("Invalid cnpj");
        }
        // Elimina possivel mascara
        $cnpj = $this->clean($cnpj);
        if($this->isInvalidLength($cnpj)) {
            return false;
        }
        if($this->allDigitsTheSame($cnpj)) {
            return false;
        }
        $j = 5;
        $k = 6;
        $soma1 = 0;
        $soma2 = 0;
        for ($i = 0; $i < 13; $i++) {
            $j = $j == 1 ? 9 : $j;
            $k = $k == 1 ? 9 : $k;
            $number = (int)substr($cnpj,$i,1);

            $soma2 += $number * $k;
            if ($i < 12) {
                $soma1 += $number * $j;
            }
            $k--;
            $j--;
        }
        $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
        $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
        return (((int)substr($cnpj,12,1) == $digito1) and ((int)substr($cnpj,13,1) == $digito2));


    }
    public function clean(string $cnpj): string
    {
        return preg_replace('/[^0-9]/','', $cnpj);
    }

    public function allDigitsTheSame(string $cnpj): false|int
    {
        /**
         * ^   => start of line (to be sure that the regex does not match just an internal substring)
         * (.) => get the first character of the string in backreference \1
         * \1* => next characters should be a repetition of the first
         * character (the captured \1)
         * $   => end of line (see start of line annotation)
         */
        return preg_match('/^(.)\1*$/u', $cnpj);
    }

    public function isInvalidLength(string $cnpj): bool
    {
        return strlen($cnpj) !== 14;
    }
    public function getValue(): string
    {
        return $this->value;
    }
}