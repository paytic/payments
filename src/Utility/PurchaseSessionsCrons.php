<?php

namespace Paytic\Payments\Utility;

use Paytic\Payments\Console\Commands\SessionsCleanup;

/**
 * Class PurchaseSessionsCrons
 * @package Paytic\Payments\Utility
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
