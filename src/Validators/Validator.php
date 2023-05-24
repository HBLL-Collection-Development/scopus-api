<?php

namespace Scopus\Validators;

/**
 * Abstract validator class. $this->validate() returns true if the identifier
 * passes validation, false if it doesn't.
 */
abstract class Validator
{
    /**
     * Validator static constructor.
     *
     * @return Validator
     */
    public static function make(): Validator
    {
        return new static();
    }

    abstract public function validate(string $identifier): bool;

    /**
     * Strip out dashes and whitespaces.
     *
     * @param string $identifier
     *
     * @return string
     */
    public function clean(string $identifier): string
    {
        return preg_replace('/[^0-9x]/i', '', $identifier);
    }
}
