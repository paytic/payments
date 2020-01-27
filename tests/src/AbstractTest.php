<?php

namespace ByTIC\Payments\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

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

    /**
     * @param $path
     * @return HttpRequest
     */
    protected function generateRequestFromFixtures($path)
    {
        $httpRequest = HttpRequest::createFromGlobals();
        $parameters = require $path;

        $httpRequest->query->replace(isset($parameters['GET']) ? $parameters['GET'] : []);
        $httpRequest->request->replace(isset($parameters['POST']) ? $parameters['POST'] : []);
        return $httpRequest;
    }

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
