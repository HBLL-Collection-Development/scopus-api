<?php

/**
 * Author Search API
 * See https://api.elsevier.com/documentation/AuthorSearchAPI.wadl for valid usage information
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-29
 *
 * @since   2017-11-29
 */

namespace Scopus;

/**
 * AuthorRetrieval Class
 */
class AuthorRetrieval extends Scopus
{
    private $eid = [];
    private $author_id = [];
    private $self_citation = [];

    public function __construct($apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
    }

    public function eid($eid)
    {
        $this->eid = ['eid' => $eid];

        return $this;
    }

    public function author_id($author_id)
    {
        $this->author_id = ['author_id' => $author_id];

        return $this;
    }

    public function self_citation($self_citation)
    {
        $this->self_citation = ['self-citation' => $self_citation];

        return $this;
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->eid, $this->author_id, $this->self_citation;

        return $this->getJson(self::AUTHOR_RETRIEVAL, $search);
    }
}
?>