<?php

/**
 * Citations Count API
 * See https://api.elsevier.com/documentation/AbstractCitationCountAPI.wadl for valid usage information
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-30
 *
 * @since   2017-11-30
 */

namespace Scopus;

/**
 * CitationsCount Class
 */
class CitationsCount extends Scopus
{
    public function __construct($apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->scopus_id, $this->doi, $this->pii, $this->pubmed_id);

        return $this->getJson(self::CITATIONS_COUNT, $search);
    }
}