<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

class Services_ResultLoader_WebService
{
    private $client;
    private $offsetKey;
    private $countKey;
    private $resultKey;

    public function __construct($client, $offsetKey, $countKey, $resultKey)
    {
        $this->client = $client;
        $this->offsetKey = $offsetKey;
        $this->countKey = $countKey;
        $this->resultKey = $resultKey;
    }

    public function __invoke($offset, $count)
    {
        if ($this->client->getMethod() == 'GET') {
            $this->client->setParameterGet(
                array_merge(
                    $this->client->getRequest()->getQuery()->getArrayCopy(),
                    [
                        $this->offsetKey => $offset,
                        $this->countKey  => $count,
                    ]
                )
            );
        } else {
            $this->client->setParameterPost(
                array_merge(
                    $this->client->getRequest()->getPost()->getArrayCopy(),
                    [
                        $this->offsetKey => $offset,
                        $this->countKey  => $count,
                    ]
                )
            );
        }

        $headers = $this->client->getRequest()->getHeaders();
        $headers->addHeaders(['Accept' => 'application/json']);

        $response = $this->client->send();
        if (! $response->isSuccess()) {
            $body = json_decode($response->getBody());
            throw new Services_Exception(tr('Remote service inaccessible (%0), error: "%1"', $response->getStatusCode(), $body->message), 400);
        }

        $out = json_decode($response->getBody(), true);
        return $out[$this->resultKey];
    }
}
