<?php

namespace ByTIC\Payments\Models\AbstractModels\HasToken;

use ByTIC\Payments\Utility\PaymentsModels;

/**
 * Trait HasTokenRepository
 * @package ByTIC\Payments\Models\AbstractModels\HasToken
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
        $this->belongsTo('Token', ['class' => get_class(PaymentsModels::tokens())]);
    }
}
