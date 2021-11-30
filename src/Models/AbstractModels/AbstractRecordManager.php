<?php

namespace ByTIC\Payments\Models\AbstractModels;

use Nip\Records\RecordManager;

/**
 * Class Subscriptions
 * @package ByTIC\Payments\Models\AbstractModels
 */
abstract class AbstractRecordManager extends RecordManager
{

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}
