<?php

/**
 * Subject Classifications API
 * See https://api.elsevier.com/documentation/SubjectClassificationsAPI.wadl for valid usage information
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-30
 *
 * @since   2017-11-30
 */

namespace Scopus;

use Exception;

/**
 * SubjectClassifications Class
 */
class SubjectClassifications extends Scopus
{
    private $url;

    private $description;
    private $detail;
    private $code;
    private $parentCode;
    private $abbrev;

    public function __construct($searchType, $apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
        $this->getUrl($searchType);
    }

    private function getUrl($searchType)
    {
        switch ($searchType) {
            case 'scidir':
                $this->url = self::SUBJECT_CLASSIFICATIONS_SCIDIR;
                break;
            case 'scopus':
                $this->url = self::SUBJECT_CLASSIFICATIONS_SCOPUS;
                break;
            default:
                throw new Exception('Incorrect ID Type used. Must be one of the following: `scidir` or `scopus`');
        }
    }

    public function description($description)
    {
        $this->description = ['description' => $description];

        return $this;
    }

    public function detail($detail)
    {
        $this->detail = ['detail' => $detail];

        return $this;
    }

    public function code($code)
    {
        $this->code = ['code' => $code];

        return $this;
    }

    public function parentCode($parentCode)
    {
        $this->parentCode = ['parentCode' => $parentCode];

        return $this;
    }

    public function abbrev($abbrev)
    {
        $this->abbrev = ['abbrev' => $abbrev];

        return $this;
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->description, $this->detail, $this->code, $this->parentCode,
            $this->abbrev, $this->field);

        return $this->getJson($this->url, $search);
    }
}