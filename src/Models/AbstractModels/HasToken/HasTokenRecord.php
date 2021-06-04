<?php

namespace ByTIC\Payments\Models\AbstractModels\HasToken;

use ByTIC\Payments\Models\Tokens\Token;
use ByTIC\Payments\Models\Tokens\TokenTrait;
use Nip\Records\Record;

/**
 * Trait HasTokenRecord
 * @package ByTIC\Payments\Models\AbstractModels\HasToken
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