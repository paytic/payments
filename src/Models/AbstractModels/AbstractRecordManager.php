<?php

namespace ByTIC\Payments\Models\AbstractModels;

use ByTIC\Records\Behaviors\I18n\I18nRecordsTrait;
use Nip\Records\RecordManager;

/**
 * Class Subscriptions
 * @package ByTIC\Payments\Models\AbstractModels
 */
abstract class AbstractRecordManager extends RecordManager
{
    use I18nRecordsTrait;

    public function getRootNamespace()
    {
        return 'ByTIC\Payments\Models\\';
    }
}
