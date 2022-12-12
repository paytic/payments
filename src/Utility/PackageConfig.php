<?php

namespace Paytic\Payments\Utility;

use Exception;
use Nip\Utility\Traits\SingletonTrait;
use Paytic\Payments\PaymentsServiceProvider;

/**
 *
 */
class PackageConfig extends \ByTIC\PackageBase\Utility\PackageConfig
{
    use SingletonTrait;

    protected $name = PaymentsServiceProvider::NAME;

    public static function configPath(): string
    {
        return __DIR__ . '/../../config/payments.php';
    }

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
