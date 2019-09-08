<?php

namespace ByTIC\Payments\Models\PurchaseSessions\Traits\Cleanup;

use Nip\Database\Query\Delete;

/**
 * Trait RecordsTrait
 * @package ByTIC\Payments\Models\PurchaseSessions\Traits\Cleanup
 */
trait RecordsTrait
{
    protected $createdDateField = 'created';
    protected $daysToKeepData = 365;

    /**
     * @return \Nip\Database\Result
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
