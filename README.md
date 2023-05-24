[![Total Downloads](https://img.shields.io/packagist/dt/hbll-collection-development/scopus-api.svg?color=blue&style=flat-square)](https://packagist.org/packages/hbll-collection-development/scopus-api)
[![Packagist](https://img.shields.io/packagist/v/hbll-collection-development/scopus-api.svg?style=flat-square)](https://packagist.org/packages/hbll-collection-development/scopus-api)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)](LICENSE.md)

# Unofficial PHP SDK for Scopus API

## Introduction

Implements the following Scopus APIs as documented here: https://dev.elsevier.com/api_docs.html

1. Affiliation Search
2. Author Search
3. Scopus Search
4. Abstract Retrieval
5. Affiliation Retrieval
6. Author Retrieval
7. Citations Count Metadata
8. Citations Overview
9. Serial Title Metadata
10. Subject Classifications

Currently, it only searches the APIs and returns the `JSON` (or `XML` upon request). Future versions will implement parsing and getting data from the `JSON`.

## Installation
Using Composer:

`composer require hbll-collection-development/scopus-api`

Or add the following to your `composer.json` file:

```json
"require": {
    "hbll-collection-development/scopus-api": "^1.0"
}
```

## Usage

For all API calls, you will need to include the Composer autoload file:

```php
require_once 'path/to/vendor/autoload.php';
```

All calls default to returning `JSON`.

Method names mirror the names of the query parameters as outlined in the API documentation unless there is a hyphen in the query parameter. In that case, the method uses and underscore instead. Methods for query parameters can be chained together to build the full query.

### Affiliation Search

API Documentation: https://api.elsevier.com/documentation/AffiliationSearchAPI.wadl

```php
$affiliationSearch = new \Scopus\AffiliationSearch('API-KEY');

$results = $affiliationSearch
         ->query('AFFIL(Brigham Young University)')
         ->count(1)
         ->search();
```

If you want `XML` instead, you can do the following:

```php
$results = $affiliationSearch
         ->query('AFFIL(Brigham Young University)')
         ->count(1)
         ->httpAccept('application/xml')
         ->search();
```

Example `JSON` response:

```json
{
  "search-results": {
    "opensearch:totalResults": "992",
    "opensearch:startIndex": "0",
    "opensearch:itemsPerPage": "1",
    "opensearch:Query": {
      "@role": "request",
      "@searchTerms": "AFFIL(Brigham Young University)",
      "@startPage": "0"
    },
    "link": [
      {
        "@_fa": "true",
        "@ref": "self",
        "@href": "https://api.elsevier.com/content/search/affiliation?start=0&count=1&query=AFFIL%28Brigham+Young+University%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      },
      {
        "@_fa": "true",
        "@ref": "first",
        "@href": "https://api.elsevier.com/content/search/affiliation?start=0&count=1&query=AFFIL%28Brigham+Young+University%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      },
      {
        "@_fa": "true",
        "@ref": "next",
        "@href": "https://api.elsevier.com/content/search/affiliation?start=1&count=1&query=AFFIL%28Brigham+Young+University%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      },
      {
        "@_fa": "true",
        "@ref": "last",
        "@href": "https://api.elsevier.com/content/search/affiliation?start=991&count=1&query=AFFIL%28Brigham+Young+University%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      }
    ],
    "entry": [
      {
        "@_fa": "true",
        "link": [
          {
            "@_fa": "true",
            "@ref": "self",
            "@href": "https://api.elsevier.com/content/affiliation/affiliation_id/60006832"
          },
          {
            "@_fa": "true",
            "@ref": "search",
            "@href": "https://api.elsevier.com/content/search/scopus?query=af-id%2860006832%29"
          },
          {
            "@_fa": "true",
            "@ref": "scopus-affiliation",
            "@href": "https://www.scopus.com/affil/profile.uri?afid=60006832&partnerID=HzOxMe3b&origin=inward"
          }
        ],
        "prism:url": "https://api.elsevier.com/content/affiliation/affiliation_id/60006832",
        "dc:identifier": "AFFILIATION_ID:60006832",
        "eid": "10-s2.0-60006832",
        "affiliation-name": "Brigham Young University",
        "name-variant": [
          {
            "@_fa": "true",
            "$": "Brigham Young University"
          }
        ],
        "document-count": "29294",
        "city": "Provo",
        "country": "United States",
        "parent-affiliation-id": "0"
      }
    ]
  }
}
```

### Author Search

API Documentation: https://api.elsevier.com/documentation/AuthorSearchAPI.wadl

```php
$authorSearch = new \Scopus\AuthorSearch('API-KEY');

$results = $authorSearch
         ->query('AUTHLASTNAME(Howland) AND AUTHFIRST(J) AND AF-ID(60006832)')
         ->search();
```

Example `JSON` response:

```json
{
  "search-results": {
    "opensearch:totalResults": "1",
    "opensearch:startIndex": "0",
    "opensearch:itemsPerPage": "1",
    "opensearch:Query": {
      "@role": "request",
      "@searchTerms": "AUTHLASTNAME(Howland) AND AUTHFIRST(J) AND AF-ID(60006832)",
      "@startPage": "0"
    },
    "link": [
      {
        "@_fa": "true",
        "@ref": "self",
        "@href": "https://api.elsevier.com/content/search/author?start=0&count=25&query=AUTHLASTNAME%28Howland%29+AND+AUTHFIRST%28J%29+AND+AF-ID%2860006832%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      },
      {
        "@_fa": "true",
        "@ref": "first",
        "@href": "https://api.elsevier.com/content/search/author?start=0&count=25&query=AUTHLASTNAME%28Howland%29+AND+AUTHFIRST%28J%29+AND+AF-ID%2860006832%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      }
    ],
    "entry": [
      {
        "@_fa": "true",
        "link": [
          {
            "@_fa": "true",
            "@ref": "self",
            "@href": "https://api.elsevier.com/content/author/author_id/14071559700"
          },
          {
            "@_fa": "true",
            "@ref": "search",
            "@href": "https://api.elsevier.com/content/search/author?query=au-id%2814071559700%29"
          },
          {
            "@_fa": "true",
            "@ref": "scopus-citedby",
            "@href": "https://www.scopus.com/author/citedby.uri?partnerID=HzOxMe3b&citedAuthorId=14071559700&origin=inward"
          },
          {
            "@_fa": "true",
            "@ref": "scopus-author",
            "@href": "https://www.scopus.com/authid/detail.uri?partnerID=HzOxMe3b&authorId=14071559700&origin=inward"
          }
        ],
        "prism:url": "https://api.elsevier.com/content/author/author_id/14071559700",
        "dc:identifier": "AUTHOR_ID:14071559700",
        "eid": "9-s2.0-14071559700",
        "preferred-name": {
          "surname": "Howland",
          "given-name": "Jared L.",
          "initials": "J.L."
        },
        "name-variant": [
          {
            "@_fa": "true",
            "surname": "Howland",
            "given-name": "Jared",
            "initials": "J."
          }
        ],
        "document-count": "4",
        "subject-area": [
          {
            "@abbrev": "SOCI",
            "@frequency": "4",
            "$": "Social Sciences (all)"
          },
          {
            "@abbrev": "COMP",
            "@frequency": "1",
            "$": "Computer Science (all)"
          }
        ],
        "affiliation-current": {
          "affiliation-url": "https://api.elsevier.com/content/affiliation/affiliation_id/60006832",
          "affiliation-id": "60006832",
          "affiliation-name": "Brigham Young University",
          "affiliation-city": "Provo",
          "affiliation-country": "United States"
        }
      }
    ]
  }
}
```

### Scopus Search

API Documentation: https://api.elsevier.com/documentation/ScopusSearchAPI.wadl

```php
$scopusSearch = new \Scopus\ScopusSearch('API-KEY');

$results = $scopusSearch
         ->query('TITLE(Tragedy of the Commons)')
         ->search();
```

Example `JSON` response:

```json
{
  "search-results": {
    "opensearch:totalResults": "432",
    "opensearch:startIndex": "0",
    "opensearch:itemsPerPage": "1",
    "opensearch:Query": {
      "@role": "request",
      "@searchTerms": "TITLE(Tragedy of the Commons)",
      "@startPage": "0"
    },
    "link": [
      {
        "@_fa": "true",
        "@ref": "self",
        "@href": "https://api.elsevier.com/content/search/scopus?start=0&count=1&query=TITLE%28Tragedy+of+the+Commons%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      },
      {
        "@_fa": "true",
        "@ref": "first",
        "@href": "https://api.elsevier.com/content/search/scopus?start=0&count=1&query=TITLE%28Tragedy+of+the+Commons%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      },
      {
        "@_fa": "true",
        "@ref": "next",
        "@href": "https://api.elsevier.com/content/search/scopus?start=1&count=1&query=TITLE%28Tragedy+of+the+Commons%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      },
      {
        "@_fa": "true",
        "@ref": "last",
        "@href": "https://api.elsevier.com/content/search/scopus?start=431&count=1&query=TITLE%28Tragedy+of+the+Commons%29&apiKey=c29c9566c80d7b2dba4db28894ac26ce",
        "@type": "application/json"
      }
    ],
    "entry": [
      {
        "@_fa": "true",
        "link": [
          {
            "@_fa": "true",
            "@ref": "self",
            "@href": "https://api.elsevier.com/content/abstract/scopus_id/85028623301"
          },
          {
            "@_fa": "true",
            "@ref": "author-affiliation",
            "@href": "https://api.elsevier.com/content/abstract/scopus_id/85028623301?field=author,affiliation"
          },
          {
            "@_fa": "true",
            "@ref": "scopus",
            "@href": "https://www.scopus.com/inward/record.uri?partnerID=HzOxMe3b&scp=85028623301&origin=inward"
          },
          {
            "@_fa": "true",
            "@ref": "scopus-citedby",
            "@href": "https://www.scopus.com/inward/citedby.uri?partnerID=HzOxMe3b&scp=85028623301&origin=inward"
          }
        ],
        "prism:url": "https://api.elsevier.com/content/abstract/scopus_id/85028623301",
        "dc:identifier": "SCOPUS_ID:85028623301",
        "eid": "2-s2.0-85028623301",
        "dc:title": "An allometric tragedy of the commons: Response to the article “Evaluation of models capacity to predict size spectra parameters in ecosystems under stress”",
        "dc:creator": "Mulder C.",
        "prism:publicationName": "Ecological Indicators",
        "prism:issn": "1470160X",
        "prism:volume": "84",
        "prism:pageRange": "161-164",
        "prism:coverDate": "2018-01-01",
        "prism:coverDisplayDate": "January 2018",
        "prism:doi": "10.1016/j.ecolind.2017.08.042",
        "pii": "S1470160X17305320",
        "citedby-count": "0",
        "affiliation": [
          {
            "@_fa": "true",
            "affilname": "National Institute of Public Health and the Environment",
            "affiliation-city": "Bilthoven",
            "affiliation-country": "Netherlands"
          }
        ],
        "prism:aggregationType": "Journal",
        "subtype": "le",
        "subtypeDescription": "Letter",
        "source-id": "20292"
      }
    ]
  }
}
```

### Abstract Retrieval

API Documentation: https://api.elsevier.com/documentation/AbstractRetrievalAPI.wadl

```php
$abstractRetrieval = new \Scopus\AbstractRetrieval('SCOPUS-ID', 'scopusId', 'API-KEY');

$results = $abstractRetrieval
         ->field('url,identifier,description')
         ->search();
```

Other options include:

```php
$abstractRetrieval = new \Scopus\AbstractRetrieval('EID', 'eid', 'API-KEY');
$abstractRetrieval = new \Scopus\AbstractRetrieval('DOI', 'doi', 'API-KEY');
$abstractRetrieval = new \Scopus\AbstractRetrieval('PII', 'pii', 'API-KEY');
$abstractRetrieval = new \Scopus\AbstractRetrieval('PUBMED-ID', 'pubmedId', 'API-KEY');
$abstractRetrieval = new \Scopus\AbstractRetrieval('PUI', 'pui', 'API-KEY');
```

For example:

```php
$abstractRetrieval = new \Scopus\AbstractRetrieval('85028623301', 'scopusId', 'API-KEY');
```

Example `JSON` response:

```json
{
  "abstracts-retrieval-response": {
    "coredata": {
      "prism:url": "https://api.elsevier.com/content/abstract/scopus_id/85028623301",
      "dc:identifier": "SCOPUS_ID:85028623301",
      "link": [
        {
          "@href": "https://api.elsevier.com/content/abstract/scopus_id/85028623301",
          "@rel": "self",
          "@_fa": "true"
        }
      ]
    }
  }
}
```

### Other

See the Scopus API Documentation page (https://dev.elsevier.com/api_docs.html) for information and hints about how the other APIs are supported by this unofficial SDK.
