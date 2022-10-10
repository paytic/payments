<?php

namespace Paytic\Payments\Utility;

/**
 *
 */
class PaymentsEvents
{
    /**
     * @param $event
     * @param ...$params
     * @return void
     */
    public static function dispatch($event, ...$params): void
    {
        $eventObject = is_object($event) ? $event : new $event($params);
        if (app()->has('events')) {
            event($eventObject);
        }
    }
}