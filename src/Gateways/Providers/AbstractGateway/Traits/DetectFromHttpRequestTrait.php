<?php

namespace ByTIC\Payments\Gateways\Providers\AbstractGateway\Traits;

use Omnipay\Common\Message\AbstractRequest;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

trait DetectFromHttpRequestTrait
{
    /**
     * @param $modelManager
     * @param null $callback
     * @param HttpRequest $httpRequest
     *
     * @return AbstractRequest|false
     */
    public function detectFromHttpRequestTrait($modelManager, $callback = null, $httpRequest = null)
    {
        $callback = $callback ? $callback : 'completePurchase';
        if ($httpRequest) {
            $this->setHttpRequest($httpRequest);
        }
        if (!method_exists($this, $callback)) {
            return false;
        }
        /** @var AbstractRequest $request */
        $request = $this->$callback(['modelManager' => $modelManager]);
        if (!is_object($request)) {
            return false;
        }
        if (!method_exists($request, 'isValidNotification')) {
            throw new \Exception("Request must have a isValidNotification public method");
        }
        if (!$request->isValidNotification()) {
            return false;
        }

        return $request;
    }
}