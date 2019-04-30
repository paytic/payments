<?php

namespace ByTIC\Payments\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    protected $object;

    /**
     * @var \Guzzle\Http\Client
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();
        $this->client = new \Guzzle\Http\Client();
        $this->client->setConfig(
            [
                'curl.CURLOPT_SSL_VERIFYHOST' => false,
                'curl.CURLOPT_SSL_VERIFYPEER' => false
            ]
        );
        $this->client->setSslVerification(false, false);
    }
}
