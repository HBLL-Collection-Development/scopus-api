<?php

namespace Scopus\Validators;

class IssnValidator extends Validator
{
    /**
     * Check if an ISSN is valid.
     * If the string without dashes is shorter or longer than 8 characters,
     * don't even trigger the check digit test and just return false.
     *
     * @param string $issn
     *
     * @return bool
     */
    public function validate(string $issn): bool
    {
        if (!$this->checkStructure($issn)) {
            return false;
        }
        if (!$this->checkLength($issn)) {
            return false;
        }

        return $this->checkDigit($issn) == $this->lastDigit($issn);
    }

    /**
     * Check if an ISSN is well formed.
     *
     * @param string $issn
     *
     * @return bool
     */
    public function checkStructure(string $issn): bool
    {
        return preg_match("/\d{4}-?\d{3}[x|\d]/i", $issn);
    }

    /**
     * Check if the length of an ISSN is 8 digits without dashes.
     *
     * @param string $issn
     *
     * @return bool
     */
    public function checkLength($issn)
    {
        return strlen($this->clean($issn)) == 8;
    }

    /**
     * Calculate the ISSN check digit.
     * Procedure: https://www.loc.gov/issn/check.html.
     *
     * @param string $issn
     *
     * @return string
     */
    public function checkDigit(string $issn): string
    {
        $digits = str_split($this->clean($issn));

        $index = 0;
        $weightingFactor = 8;
        $sum = 0;
        while ($index < 7) {
            $sum += ((int)$digits[$index++] * $weightingFactor--);
        }

        $remainder = $sum % 11;
        $checkDigit = 11 - $remainder;

        if ($checkDigit == 10) {
            return 'X';
        }

        return $checkDigit;
    }

    /**
     * Return the last digit of an ISSN.
     *
     * @param string $issn
     *
     * @return string
     */
    public function lastDigit(string $issn): string
    {
        return substr($issn, -1);
    }
}
