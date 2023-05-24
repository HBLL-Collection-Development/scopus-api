<?php

/**
 * Author Search API
 * See https://api.elsevier.com/documentation/AuthorSearchAPI.wadl for valid usage information
 *
 * @author  Jared Howland <scopus@jaredhowland.com>
 *
 * @version 2017-12-04
 *
 * @since   2017-12-04
 */

namespace Scopus\Parsers;

/**
 * AuthorSearch Parser Class
 */
class AuthorSearch extends \Scopus\Parser
{
    public function __construct($json)
    {
        parent::__construct($json);
    }

    public function numResults()
    {
        $this->fields['numResults'] = $this->array['search_results']['opensearch_totalResults'];

        return $this;
    }

    public function entries()
    {
        $this->fields['entries'] = $this->array['search_results']['entry'];

        return $this;
    }

    public function entry($entry)
    {
        $this->links($entry['link']);

        return $this;
    }

    public function links($links)
    {
        $allLinks = [];
        foreach ($links as $value) {
            switch ($links['ref']) {
                case 'self':
                    $allLinks['api'] = $value;
                    break;
                case 'search':
                    $allLinks['search'] = $value;
                    break;
                case 'scopus_citedby':
                    $allLinks['citedBy'] = $value;
                    break;
                case 'scopus_author':
                    $allLinks['author'] = $value;
                    break;
            }
        }
        $this->fields['links'] = $allLinks;

        return $this;
    }

}