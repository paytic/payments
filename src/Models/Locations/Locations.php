<?php

namespace Paytic\Payments\Models\Locations;

use Paytic\Payments\Models\AbstractModels\AbstractRecordManager;

/**
 * Class Locations
 * @package Paytic\Payments\Models\Locations
 */
class Locations extends AbstractRecordManager
{
    public const TABLE = 'payments-locations';
    public const CONTROLLER = 'payments-locations';

    use LocationsTrait;
}
