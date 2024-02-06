<?php

namespace Paytic\Payments\Subscriptions\Actions\Lifecycle;

use Bytic\Actions\Action;
use Bytic\Actions\Behaviours\HasSubject\HasSubject;
use Paytic\Payments\Utility\PaymentsEvents;

/**
 * Class StartSubscription
 * @package Paytic\Payments\Subscriptions\Actions\Lifecycle
 */
abstract class AbstractAction extends Action
{
    use HasSubject;

    protected $trigger = null;

    public function setTrigger($trigger)
    {
        $this->trigger = $trigger;
        return $this;
    }

    protected function triggerEvent($event, $params = [])
    {
        $params = array_merge($params, ['trigger' => $this->trigger]);
        PaymentsEvents::dispatch($event, $this->getSubject(), $params);
    }
}
