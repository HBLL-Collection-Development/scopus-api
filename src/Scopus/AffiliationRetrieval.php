<?php

/**
 * Affiliation Retrieval API
 * See https://api.elsevier.com/documentation/AffiliationRetrievalAPI.wadl for valid usage information
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
 * AffiliationRetrieval Class
 */
class AffiliationRetrieval extends Scopus
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
            case 'affiliationId':
                $this->url = self::AFFILIATION_RETRIEVAL_AF_ID;
                break;
            case 'eid':
                $this->url = self::AFFILIATION_RETRIEVAL_EID;
                break;
            default:
                throw new Exception('Incorrect ID Type used. Must be one of the following: `affiliationId` or `eid`');
        }
    }

    public function search()
    {
        $search = array_merge($this->httpAccept, $this->access_token, $this->insttoken, $this->reqId, $this->ver,
            $this->view, $this->field, $this->start, $this->count, $this->startref,
            $this->refcount);

        return $this->getJson($this->url.$this->id, $search);
    }
}