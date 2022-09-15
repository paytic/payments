<?php

namespace Paytic\Payments\Models\AbstractModels\HasToken;

use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Models\Tokens\TokenTrait;
use Nip\Records\Record;

/**
 * Trait HasTokenRecord
 * @package Paytic\Payments\Models\AbstractModels\HasToken
 *
 * @property int $id_token
 * @method Token getToken()
 */
trait HasTokenRecord
{
    /**
     * @param TokenTrait|Record $token
     */
    public function populateFromToken($token)
    {
        $this->id_token = $token->id;
        $this->getRelation('Token')->setResults($token);
    }
}
