<?php

namespace ByTIC\Payments\Tests\Fixtures\Records;

use Nip\Records\AbstractModels\RecordManager;

/**
 * Class PurchasableRecord
 */
class PurchasableRecordManager extends RecordManager
{
    protected $primaryKey = 'id';

    public function getPaymentsUrlPK()
    {
        return 'id';
    }
}
