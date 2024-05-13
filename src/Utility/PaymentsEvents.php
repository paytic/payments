<?php

namespace Paytic\Payments\Utility;

use Bytic\EventDiscovery\RaiseEvent;

/**
 *
 */
class PaymentsEvents extends RaiseEvent
{
    public static function listenerPaths(): array
    {
        return [
            __DIR__ . '/../Subscriptions/Listeners',
        ];
    }
}