<?php

namespace ByTIC\Payments\Models\PurchaseSessions;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use ByTIC\Payments\Models\AbstractModels\HasGateway\HasGatewayRecordTrait;
use ByTIC\Payments\Models\AbstractModels\HasPurchaseParent;

/**
 * Trait PurchaseSessionTrait
 * @package ByTIC\Payments\Models\PurchaseSessions
 *
 * @property string $type
 * @property string $new_status
 * @property string $gateway
 * @property string $post
 * @property string $get
 * @property string $debug
 * @property string $created
 *
 * @method PurchaseSessionsTrait getManager
 */
trait PurchaseSessionTrait
{
    use HasPurchaseParent {
        populateFromPayment as populateFromPaymentTrait;
    }
    use HasGatewayRecordTrait;
    use TimestampableTrait;

    /**
     * @var string
     */
    protected static $createTimestamps = ['created'];

    /**
     * @var string
     */
    protected static $updateTimestamps = [];

    /**
     * @param $payment
     * @return $this
     */
    public function populateFromPayment($payment)
    {
        $this->populateFromPaymentTrait($payment);
        $this->new_status = (string) $payment->status;

        return $this;
    }

    /**
     * @param $response
     */
    public function populateFromResponse($response)
    {
        if (method_exists($response, 'getSessionDebug')) {
            $this->debug = $this->getManager()::encodeParams($response->getSessionDebug());
        }
    }

    public function populateFromRequest()
    {
        $this->post = $this->getManager()::encodeParams($_POST);
        $this->get = $this->getManager()::encodeParams($_GET);
    }
}
