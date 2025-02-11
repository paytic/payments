<?php

namespace Paytic\Payments\Models\AbstractModels\HasDatabase;

use Nip\Database\Connections\Connection;
use Paytic\Payments\Utility\PackageConfig;
use function app;

/**
 * Trait HasDatabaseConnectionTrait
 * @package Marktic\Newsletter\Models\AbstractModels
 */
trait HasDatabaseConnectionTrait
{

    /**
     * @return Connection
     */
    protected function newDbConnection()
    {
        return app('db')->connection(PackageConfig::databaseConnection());
    }
}

