<?php

/**
 * Serial Title Metadata API
 * See http://api.elsevier.com/documentation/SerialTitleAPI.wadl for valid usage information
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-29
 *
 * @since   2017-11-29
 */

namespace Scopus;

use Exception;

/**
 * SerialTitle Class
 */
class SerialTitle extends Scopus
{
    private $title = [];
    private $issn = [];
    private $pub = [];
    private $oa = [];

    public function __construct($apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
    }

    public function title($title)
    {
        $this->title = ['title' => $title];

        return $this;
    }

    public function issn($issn)
    {
        if ($this->isValidIssn($issn)) {
            $this->issn = ['issn' => $issn];
        } else {
            throw new Exception('The ISSN you entered is not valid.');
        }

        return $this;
    }

    public function isValidIssn($issn)
    {
        $validate = new \Scopus\Validators\IssnValidator;

        return $validate->validate($issn);
    }

    public function pub($pub)
    {
        $this->pub = ['pub' => $pub];

        return $this;
    }

    public function oa($oa)
    {
        $this->oa = ['oa' => $oa];

        return $this;
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->start, $this->count, $this->view, $this->field, $this->title,
            $this->issn, $this->pub, $this->subj, $this->content, $this->date, $this->oa);

        return $this->getJson(self::SERIAL_TITLE, $search);
    }
}