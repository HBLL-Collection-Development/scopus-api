<?php

/**
 * Scopus API Class
 *
 * API Documentation: https://dev.elsevier.com/api_docs.html
 *
 * Heavily influenced by https://github.com/kasparsj/scopus-api-php
 * kasparsj/scopus-search-api
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-11-30
 *
 * @since   2017-11-29
 */

namespace Scopus;

use Exception;
use GuzzleHttp\Client;

/**
 * Scopus Class
 */
class Scopus
{
    const TIMEOUT = 30.0;
    const ACCEPT_HEADER = 'application/json';

    // Interfaces: https://api.elsevier.com/documentation/AbstractRetrievalAPI.wadl
    // Views:      https://dev.elsevier.com/guides/AbstractRetrievalViews.htm
    const ABSTRACT_RETRIEVAL_SCOPUS_ID = 'https://api.elsevier.com/content/abstract/scopus_id/';
    const ABSTRACT_RETRIEVAL_EID = 'https://api.elsevier.com/content/abstract/eid/';
    const ABSTRACT_RETRIEVAL_DOI = 'https://api.elsevier.com/content/abstract/doi/';
    const ABSTRACT_RETRIEVAL_PII = 'https://api.elsevier.com/content/abstract/pii/';
    const ABSTRACT_RETRIEVAL_PUBMED_ID = 'https://api.elsevier.com/content/abstract/pubmed_id/';
    const ABSTRACT_RETRIEVAL_PUI = 'https://api.elsevier.com/content/abstract/pui/';
    // Tips:       https://dev.elsevier.com/tips/AffiliationSearchTips.htm
    // Interfaces: https://api.elsevier.com/documentation/AffiliationSearchAPI.wadl
    // Views:      https://dev.elsevier.com/guides/AffiliationSearchViews.htm
    const AFFILIATION_SEARCH = 'https://api.elsevier.com/content/search/affiliation';
    // Interfaces: https://api.elsevier.com/documentation/AffiliationRetrievalAPI.wadl
    // Views:      https://api.elsevier.com/documentation/guides/AffiliationRetrievalViews.htm
    const AFFILIATION_RETRIEVAL_AF_ID = 'https://api.elsevier.com/content/affiliation/affiliation_id/';
    const AFFILIATION_RETRIEVAL_EID = 'https://api.elsevier.com/content/affiliation/eid/';
    // Tips:       http://api.elsevier.com/content/search/fields/author
    // Interfaces: https://api.elsevier.com/documentation/AuthorSearchAPI.wadl
    // Views:      https://dev.elsevier.com/guides/AuthorSearchViews.htm
    const AUTHOR_SEARCH = 'https://api.elsevier.com/content/search/author';
    // Interfaces: https://api.elsevier.com/documentation/AuthorRetrievalAPI.wadl
    // Views:      https://api.elsevier.com/documentation/guides/AuthorRetrievalViews.htm
    const AUTHOR_RETRIEVAL = 'https://api.elsevier.com/content/author';
    // Interfaces: https://api.elsevier.com/documentation/AbstractCitationCountAPI.wadl
    // Views:      https://dev.elsevier.com/guides/AbstractCitationCountViews.htm
    const CITATIONS_COUNT = 'https://api.elsevier.com/content/abstract/citation-count';
    // Interfaces: https://api.elsevier.com/documentation/AbstractCitationAPI.wadl
    // Views:      https://api.elsevier.com/documentation/guides/AbstractCitationViews.htm
    const CITATIONS_OVERVIEW = 'https://api.elsevier.com/content/abstract/citations';
    // Tips:       https://dev.elsevier.com/tips/ScopusSearchTips.htm
    // Interfaces: https://api.elsevier.com/documentation/ScopusSearchAPI.wadl
    // Views:      https://dev.elsevier.com/guides/ScopusSearchViews.htm
    const SCOPUS_SEARCH = 'https://api.elsevier.com/content/search/scopus';
    // Interfaces: http://api.elsevier.com/documentation/SerialTitleAPI.wadl
    // Views:      https://api.elsevier.com/documentation/guides/SerialTitleViews.htm
    const SERIAL_TITLE = 'https://api.elsevier.com/content/serial/title';
    // Interfaces: https://api.elsevier.com/documentation/SubjectClassificationsAPI.wadl
    const SUBJECT_CLASSIFICATIONS_SCIDIR = 'https://api.elsevier.com/content/subject/scidir';
    const SUBJECT_CLASSIFICATIONS_SCOPUS = 'https://api.elsevier.com/content/subject/scopus';

    protected $apiKey;
    protected $client;

    // Common variables across multiple APIs
    protected $httpAccept = ['httpAccept' => 'application/json'];
    protected $access_token = [];
    protected $insttoken = [];
    protected $reqId = [];
    protected $ver = [];
    protected $query = [];
    protected $count = [];
    protected $sort = [];
    protected $view = [];
    protected $facets = [];
    protected $subj = [];
    protected $content = [];
    protected $suppressNavLinks = [];
    protected $field = [];
    protected $date = [];
    protected $start = [];
    protected $alias = [];
    protected $startref = [];
    protected $refcount = [];
    protected $scopus_id = [];
    protected $doi = [];
    protected $pii = [];
    protected $pubmed_id = [];

    /**
     * Scopus constructor
     *
     * @param string $apiKey  Scopus API Key
     * @param float  $timeout Timeout of Guzzle request in seconds
     */
    protected function __construct($apiKey = null, $timeout = null)
    {
        $this->setApiKey($apiKey);
        $this->setClient($timeout);
    }

    protected function setApiKey($apiKey = null)
    {
        if (empty($apiKey)) {
            throw new Exception('You must set the API Key before making a call.');
        } else {
            $this->apiKey = $apiKey;
        }
    }

    protected function setClient($timeout = null)
    {
        $timeout = empty($timeout) ? self::TIMEOUT : $timeout;
        $this->client = new Client([
            'timeout' => $timeout,
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);
    }

    public function httpAccept($httpAccept)
    {
        $this->httpAccept = ['httpAccept' => $httpAccept];

        return $this;
    }

    public function access_token($access_token)
    {
        $this->access_token = ['access_token' => $access_token];

        return $this;
    }

    public function insttoken($insttoken)
    {
        $this->insttoken = ['insttoken' => $insttoken];

        return $this;
    }

    public function reqId($reqId)
    {
        $this->reqId = ['reqId' => $reqId];

        return $this;
    }

    public function ver($ver)
    {
        $this->ver = ['ver' => $ver];

        return $this;
    }

    public function query($query)
    {
        $this->query = ['query' => $query];

        return $this;
    }

    public function count($count)
    {
        $this->count = ['count' => $count];

        return $this;
    }

    public function sort($sort)
    {
        $this->sort = ['sort' => $sort];

        return $this;
    }

    public function view($view)
    {
        $this->view = ['view' => $view];

        return $this;
    }

    public function facets($facets)
    {
        $this->facets = ['facets' => $facets];

        return $this;
    }

    public function subj($subj)
    {
        $this->subj = ['subj' => $subj];

        return $this;
    }

    public function content($content)
    {
        $this->content = ['content' => $content];

        return $this;
    }

    public function suppressNavLinks()
    {
        $this->suppressNavLinks = ['suppressNavLinks' => 'true'];

        return $this;
    }

    public function field($field)
    {
        $this->field = ['field' => $field];

        return $this;
    }

    public function date($date)
    {
        $this->date = ['date' => $date];

        return $this;
    }

    public function start($start)
    {
        $this->start = ['start' => $start];

        return $this;
    }

    public function alias($alias)
    {
        $this->alias = ['alias' => $alias];

        return $this;
    }

    public function startref($startref)
    {
        $this->startref = ['startref' => $startref];

        return $this;
    }

    public function refcount($refcount)
    {
        $this->refcount = ['refcount' => $refcount];

        return $this;
    }

    public function scopus_id($scopus_id)
    {
        $this->scopus_id = ['scopus_id' => $scopus_id];

        return $this;
    }

    public function doi($doi)
    {
        $this->doi = ['doi' => $doi];

        return $this;
    }

    public function pii($pii)
    {
        $this->pii = ['pii' => $pii];

        return $this;
    }

    public function pubmed_id($pubmed_id)
    {
        $this->pubmed_id = ['pubmed_id' => $pubmed_id];

        return $this;
    }

    protected function getJson($url, $params)
    {
        $params = array_merge($params, ['apiKey' => $this->apiKey]);
        $response = $this->client->get($url, ['query' => $params]);

        return (string)$response->getBody();
    }
}