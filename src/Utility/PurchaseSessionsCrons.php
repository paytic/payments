<?php

namespace ByTIC\Payments\Utility;

use ByTIC\Payments\Console\Commands\SessionsCleanup;

/**
 * Class PurchaseSessionsCrons
 * @package ByTIC\Payments\Utility
 */
class PurchaseSessionsCrons
{
    /**
     * @return int
     */
    public static function cleanup()
    {
        return (new SessionsCleanup())->handle();
    }
}
