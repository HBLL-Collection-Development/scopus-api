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

namespace Scopus\Parsers;

/**
 * Parser Class
 */
class AbstractRetrieval extends \Scopus\Parser
{
    public function __construct($json)
    {
        parent::__construct($json);
    }

    public function scopusId()
    {
        $scopusId = $this->json['abstracts-retrieval-response']['coredata']['dc:identifier'];
        echo "id: '$scopusId'";
        $this->fields = array_merge($this->fields, ['scopusId' => $scopusId]);
        return $this;
    }
}