<?php

namespace ByTIC\Payments\Console\Commands;

use ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionsTrait;
use Nip\Records\Locator\ModelLocator;

/**
 * Class SessionsCleanup
 * @package Nip\Payments\Console\Commands
 */
class SessionsCleanup
{
    protected $modelName = 'purchase-sessions';

    /**
     * @return int
     */
    public function handle()
    {
        /** @var PurchaseSessionsTrait $manager */
        $manager = app('purchase-sessions');
        $result = $manager->reduceOldSessions();
        $rows = $result->numRows();
        return is_int($rows) ? $rows : 0;
    }
}
