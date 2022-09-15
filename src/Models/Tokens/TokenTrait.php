<?php

namespace Paytic\Payments\Models\Tokens;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;
use Paytic\Payments\Models\AbstractModels\HasCustomer\HasCustomerRecord;
use Paytic\Payments\Models\AbstractModels\HasGateway\HasGatewayRecordTrait;
use Paytic\Payments\Models\AbstractModels\HasPaymentMethod\HasPaymentMethodRecord;
use Paytic\Payments\Models\AbstractModels\HasPurchaseParent;
use Paytic\Omnipay\Common\Models\TokenInterface;

/**
 * Trait TokenTrait
 * @package Paytic\Payments\Models\Tokens
 *
 * @property int $id_method
 * @property string $gateway
 *
 * @property string $token_id
 * @property string $expiration
 *
 * @property string $modified
 * @property string $created
 *
 * @method TokensTrait getManager
 */
trait TokenTrait
{
    use HasPurchaseParent;
    use HasCustomerRecord;
    use HasGatewayRecordTrait;
    use HasPaymentMethodRecord;
    use TimestampableTrait;

    protected $token_id;

    /**
     * @var string
     */
    protected static $createTimestamps = ['created'];

    /**
     * @var string
     */
    protected static $updateTimestamps = ['modified'];

    public function getName(): string
    {
        return 'Token '
            . $this->getMaskedTokenId();
    }

    public function getMaskedTokenId(): string
    {
        return substr($this->token_id, 0, 4)
            . '***'
            . substr($this->token_id, -4);
    }

    public function getTokenId(): string
    {
        return $this->token_id;
    }

    /**
     * @param TokenInterface $token
     */
    public function populateFromToken(TokenInterface $token)
    {
        $this->token_id = $token->getId();
        $this->expiration = $token->getExpirationDate();
    }

    /**
     * @return \Paytic\Omnipay\Common\Models\Token
     */
    public function getOmnipayToken(): \Paytic\Omnipay\Common\Models\Token
    {
        return new \Paytic\Omnipay\Common\Models\Token([
            'id' => $this->token_id,
            'expiration_date' => $this->expiration,
        ]);
    }
}
