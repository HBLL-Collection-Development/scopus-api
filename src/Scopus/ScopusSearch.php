<?php

/**
 * Scopus Search API
 * See https://api.elsevier.com/documentation/ScopusSearchAPI.wadl for valid usage information
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-30
 *
 * @since   2017-11-30
 */

namespace Scopus;

/**
 * ScopusSearch Class
 */
class ScopusSearch extends Scopus
{
    public function __construct($apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->query, $this->view, $this->field, $this->suppressNavLinks, $this->date,
            $this->start, $this->count, $this->sort, $this->content, $this->subj, $this->alias, $this->facets);

        return $this->getJson(self::SCOPUS_SEARCH, $search);
    }
}