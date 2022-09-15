<?php

namespace Paytic\Payments\Models\Currencies\Traits;

use Nip\Records\Traits\AbstractTrait\RecordsTrait;

/**
 * Trait CurrenciesTrait
 * @package Paytic\Payments\Models\Currencies\Traits
 */
trait CurrenciesTrait
{
    use RecordsTrait;

    /**
     * @param string $code
     * @return CurrencyTrait
     */
    public function getByCode($code)
    {
        return $this->findOne($code);
    }
}
