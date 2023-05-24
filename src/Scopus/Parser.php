<?php

/**
 * Parser Class
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-30
 *
 * @since   2017-11-29
 */

namespace Scopus;

/**
 * Parser Class
 */
class Parser
{
    protected $json;
    protected $array;
    protected $fields = [];

    /**
     * Parser constructor
     *
     * @param string $json JSON to parse
     */
    protected function __construct($json)
    {
        $this->json = $json;
        $this->array = json_decode($this->json, true);
        $this->array = $this->fixKeys($this->array);
    }

    private function fixKeys($array)
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $search = ['_', '-', ':', '@'];
            $replace = ['', '_', '_', ''];
            $newArray[str_replace($search, $replace, $key)] = (is_array($value)) ? $this->fixKeys($value) : $value;
        }

        return $newArray;
    }

    public function retrieve()
    {
        return $this->fields;
    }
}