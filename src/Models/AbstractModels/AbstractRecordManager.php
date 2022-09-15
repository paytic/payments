<?php

namespace Paytic\Payments\Models\AbstractModels;

use ByTIC\Records\Behaviors\I18n\I18nRecordsTrait;
use Nip\Records\Filters\Records\HasFiltersRecordsTrait;
use Nip\Records\RecordManager;

/**
 * Class Subscriptions
 * @package Paytic\Payments\Models\AbstractModels
 */
abstract class AbstractRecordManager extends RecordManager
{
    use I18nRecordsTrait;
    use HasFiltersRecordsTrait;

    public function getRootNamespace(): string
    {
        return 'Paytic\Payments\Models\\';
    }
}
