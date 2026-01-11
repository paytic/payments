<?php

namespace Paytic\Payments\PurchaseSessions\Models;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use Paytic\Payments\Models\AbstractModels\HasGateway\HasGatewayRecordTrait;
use Paytic\Payments\Models\AbstractModels\HasPurchaseParent;
use Paytic\Payments\PurchaseSessions\Actions\PopulateSessionFromResponse;

/**
 * Trait PurchaseSessionTrait
 * @package Paytic\Payments\Models\PurchaseSessions
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
        PopulateSessionFromResponse::forResponse($this, $response)->handle();
    }

    public function populateFromRequest()
    {
        $this->post = $this->getManager()::encodeParams($_POST);
        $this->get = $this->getManager()::encodeParams($_GET);
    }
}
