<?php

namespace Paytic\Payments\PurchaseSessions\Actions;

use Bytic\Actions\Action;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class PopulateSessionFromResponse extends Action
{
    protected $sessionRepository;

    protected $session;

    protected $response;

    public function __construct()
    {
        $this->sessionRepository = PaymentsModels::sessions();
    }

    public static function forResponse($session, $response): static
    {
        $action = new static();
        $action->session = $session;
        $action->response = $response;

        return $action;
    }

    public function handle()
    {
        $this->populate();
    }

    protected function populate()
    {
        $data = [];
        if (method_exists($this->response, 'isSuccessful')) {
            $data['isSuccessful'] = $this->response->isSuccessful();
        }
        if (method_exists($this->response, 'getTransactionReference')) {
            $data['transactionReference'] = $this->response->getTransactionReference();
        }
        if (method_exists($this->response, 'getTransactionId')) {
            $data['transactionId'] = $this->response->getTransactionId();
        }
        if (method_exists($this->response, 'getCode')) {
            $data['code'] = $this->response->getCode();
        }
        if (method_exists($this->response, 'getMessage')) {
            $data['message'] = $this->response->getMessage();
        }
        if (method_exists($this->response, 'getSessionDebug')) {
            $data['notify'] = $this->response->getSessionDebug();
        }
        $this->session->debug = $this->encodeParams($data);
    }

    protected function encodeParams($params)
    {
        return $this->sessionRepository::encodeParams($params);
    }
}

