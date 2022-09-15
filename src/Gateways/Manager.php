<?php

namespace Paytic\Payments\Gateways;

use Exception;
use Omnipay\Common\Message\ResponseInterface;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\DetectFromHttpRequestTrait;
use Paytic\Payments\Gateways\Providers\AbstractGateway\Traits\GatewayTrait;
use Paytic\Payments\Legacy\Gateways\Manager\Traits\StaticCallsTrait;
use Nip\Records\AbstractModels\RecordManager;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\AbstractResponse;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Class Manager
 * @package Paytic\Payments\Gateways
 */
class Manager
{
    use Manager\Traits\HasFactoryTrait;
    use Manager\Traits\HasGatewaysCollectionTrait;
//    use StaticCallsTrait;


    /**
     * @param null|Manager $newInstance
     * @return Manager
     */
    public static function instance($newInstance = null): Manager
    {
        static $instance;
        if ($newInstance instanceof self) {
            $instance = $newInstance;
            return $instance;
        }
        if (!($instance instanceof self)) {
            $instance = new self();
        }
        return $instance;
    }

    /**
     * @param RecordManager $modelManager
     * @param string $callback
     * @param null|HttpRequest $httpRequest
     * @return bool|ResponseInterface
     */
    public static function detectItemFromHttpRequest($modelManager, $callback = null, $httpRequest = null)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        $request = self::getRequestFromHttpRequest($modelManager, $callback, $httpRequest);
        if (!is_subclass_of($request, AbstractRequest::class)) {
            return false;
        }

        $response = $request->send();
        if (!is_subclass_of($response, AbstractResponse::class)) {
            return false;
        }
        return $response;
    }


    /**
     * @param RecordManager $modelManager
     * @param string $callback
     * @param null|HttpRequest $httpRequest
     * @return bool|ResponseInterface
     * @throws Exception
     */
    public static function getRequestFromHttpRequest($modelManager, $callback = null, $httpRequest = null)
    {
        /** @var DetectFromHttpRequestTrait[] $items */
        $items = self::getAll();

        foreach ($items as $item) {
            $request = $item->detectFromHttpRequestTrait($modelManager, $callback, $httpRequest);
            if (is_subclass_of($request, AbstractRequest::class)) {
                return $request;
            }
        }

        return false;
    }

    /**
     * @param $type
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function getLabel($type, $params = [], $language = false)
    {
        return translator()->trans('payment-gateways.labels.' . $type, $params, $language);
    }

    /**
     * @param $name
     * @param array $params
     * @param bool $language
     * @return string
     */
    public function getMessage($name, $params = [], $language = false)
    {
        return translator()->trans('payment-gateways.messages.' . $name, $params, $language);
    }
}
