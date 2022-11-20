<?php

namespace Paytic\Payments\Models\Locations;

use ByTIC\DataObjects\Behaviors\Timestampable\TimestampableTrait;

/**
 * Trait LocationTrait
 * @package Paytic\Payments\Models\Locations
 *
 * @property string $modified
 * @property string $created
 *
 * @method LocationsTrait getManager
 */
trait LocationTrait
{
    use TimestampableTrait;

    /**
     * @var string
     */
    protected static $createTimestamps = ['created'];

    /**
     * @var string
     */
    protected static $updateTimestamps = ['modified'];

}
