<?php

/**
 * Abstract Retrieval API
 * See https://api.elsevier.com/documentation/AbstractRetrievalAPI.wadl for valid usage information
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
 * AbstractRetrieval Class
 */
class AbstractRetrieval extends Scopus
{
    private $id;
    private $url;

    public function __construct($id, $idType, $apiKey = null, $timeout = null)
    {
        parent::__construct($apiKey, $timeout);
        $this->id = $id;
        $this->getUrl($idType);
    }

    private function getUrl($idType)
    {
        switch ($idType) {
            case 'scopusId':
                $this->url = self::ABSTRACT_RETRIEVAL_SCOPUS_ID;
                break;
            case 'eid':
                $this->url = self::ABSTRACT_RETRIEVAL_EID;
                break;
            case 'doi':
                $this->url = self::ABSTRACT_RETRIEVAL_DOI;
                break;
            case 'pii':
                $this->url = self::ABSTRACT_RETRIEVAL_PII;
                break;
            case 'pubmedId':
                $this->url = self::ABSTRACT_RETRIEVAL_PUBMED_ID;
                break;
            case 'pui':
                $this->url = self::ABSTRACT_RETRIEVAL_PUI;
                break;
            default:
                throw new Exception('Incorrect ID Type used. Must be one of the following: `scopusId`, `eid`, `doi`, `pii`, `pubmedId`, or `pui`');
        }
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->view, $this->field, $this->startref, $this->refcount);

        return $this->getJson($this->url.$this->id, $search);
    }
}