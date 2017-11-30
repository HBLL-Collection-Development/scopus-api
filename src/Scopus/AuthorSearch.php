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
 * AuthorSearch Class
 */
class AuthorSearch extends Scopus
{
    private $co_author = [];

    public function __construct($apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
    }

    public function co_author($co_author)
    {
        $this->co_author = ['co-author' => $co_author];

        return $this;
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->query, $this->co_author, $this->view, $this->field, $this->suppressNavLinks,
            $this->start, $this->count, $this->sort, $this->facets, $this->alias);

        return $this->getJson(self::AUTHOR_SEARCH, $search);
    }
}