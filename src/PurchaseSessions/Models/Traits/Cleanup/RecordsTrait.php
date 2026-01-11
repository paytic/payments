<?php

namespace Paytic\Payments\PurchaseSessions\Models\Traits\Cleanup;

use Nip\Database\Query\Delete;
use Nip\Database\Result;

/**
 * Trait RecordsTrait
 * @package Paytic\Payments\Models\PurchaseSessions\Traits\Cleanup
 */
trait RecordsTrait
{
    protected $createdDateField = 'created';
    protected $daysToKeepData = 365;

    /**
     * @return Result
     */
    public function reduceOldSessions()
    {
        /** @var Delete $query */
        $query = $this->newDeleteQuery();
        $query->where(
            '`' . $this->createdDateField . '` <= DATE_SUB(CURRENT_DATE(), INTERVAL ' . $this->daysToKeepData . ' DAY)'
        );

        return $query->execute();
    }
}
