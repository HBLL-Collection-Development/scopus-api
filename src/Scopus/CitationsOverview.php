<?php

/**
 * Citations Overview API
 * See https://api.elsevier.com/documentation/AbstractCitationAPI.wadl for valid usage information
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-30
 *
 * @since   2017-11-30
 */

namespace Scopus;

/**
 * CitationsOverview Class
 */
class CitationsOverview extends Scopus
{
    private $citation;
    private $author_id;

    public function __construct($apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
    }

    public function citation($citation)
    {
        $this->citation = ['citation' => $citation];

        return $this;
    }

    public function author_id($author_id)
    {
        $this->author_id = ['author_id' => $author_id];

        return $this;
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->start, $this->count, $this->view, $this->field, $this->sort, $this->date, $this->citation,
            $this->author_id, $this->scopus_id, $this->doi, $this->pii, $this->pubmed_id);

        return $this->getJson(self::CITATIONS_OVERVIEW, $search);
    }
}