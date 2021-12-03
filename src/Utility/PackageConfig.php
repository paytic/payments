<?php

namespace ByTIC\Payments\Utility;

use ByTIC\Payments\PaymentsServiceProvider;
use Exception;
use Nip\Utility\Traits\SingletonTrait;

/**
 *
 */
class PackageConfig extends \ByTIC\PackageBase\Utility\PackageConfig
{
    use SingletonTrait;

    protected $name = PaymentsServiceProvider::NAME;

    /**
     * @return string|null
     * @throws Exception
     */
    public static function databaseConnection(): ?string
    {
        return (string)static::instance()->get('database.connection');
    }

    public static function shouldRunMigrations(): bool
    {
        return static::instance()->get('database.migrations', false) !== false;
    }
}
