<?php

namespace ByTIC\Payments\Models\AbstractModels;

use ByTIC\Records\Behaviors\I18n\I18nRecordsTrait;
use Nip\Records\Filters\Records\HasFiltersRecordsTrait;
use Nip\Records\RecordManager;

/**
 * Class Subscriptions
 * @package ByTIC\Payments\Models\AbstractModels
 */
abstract class AbstractRecordManager extends RecordManager
{
    use I18nRecordsTrait;
    use HasFiltersRecordsTrait;

    public function getRootNamespace(): string
    {
        return 'ByTIC\Payments\Models\\';
    }
}
