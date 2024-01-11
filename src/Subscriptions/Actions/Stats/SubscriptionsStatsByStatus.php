<?php

namespace Paytic\Payments\Subscriptions\Actions\Stats;

use Bytic\Actions\Action;
use Nip\Utility\Arr;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
class SubscriptionsStatsByStatus extends Action
{

    public function execute()
    {
        return $this->initStats();
    }

    protected function initStats()
    {
        $query = PaymentsModels::subscriptions()->newQuery();
        $query->setCols('status', 'count(*) as total');
        $query->group('status');

        $stats = $query->execute()->fetchResults();
        $stats = Arr::keyBy($stats, 'status');

        $statuses = PaymentsModels::subscriptions()->getStatuses();
        foreach ($statuses as $status) {
            $stat = $stats[$status->getName()] ?? [];
            $count = $stat['total'] ?? 0;
            $status->count = $count;
        }
        return $statuses;
    }
}
