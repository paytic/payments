<?php

namespace Paytic\Payments\Models\AbstractModels\HasToken;

use Paytic\Payments\Utility\PaymentsModels;

/**
 * Trait HasTokenRepository
 * @package Paytic\Payments\Models\AbstractModels\HasToken
 */
trait HasTokenRepository
{
    public function initRelations()
    {
        parent::initRelations();
        $this->initRelationsToken();
    }

    protected function initRelationsToken()
    {
        $this->belongsTo('Token', ['class' => get_class(PaymentsModels::tokens()), 'fk' => 'id_token']);
    }
}
