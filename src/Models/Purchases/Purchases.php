<?php

namespace ByTIC\Payments\Models\Purchases;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableRepositoryTrait;
use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Purchases
 * @package ByTIC\Payments\Models\Purchases
 */
class Purchases extends RecordManager
{
    use SingletonTrait;
    use IsPurchasableRepositoryTrait;
}