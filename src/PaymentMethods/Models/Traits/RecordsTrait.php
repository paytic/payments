<?php

namespace Paytic\Payments\PaymentMethods\Models\Traits;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordsTrait as HasTypesRecordsTrait;
use Exception;
use Nip\Config\Config;
use Paytic\Payments\Models\AbstractModels\HasDatabase\HasDatabaseConnectionTrait;
use Paytic\Payments\Models\Methods\PaymentMethods;
use Paytic\Payments\PaymentsServiceProvider;
use Paytic\Payments\Utility\PaymentsModels;

/**
 * Class RecordsTrait
 * @package Paytic\Payments\Models\Methods\Traits
 *
 * @method getMessage($name, $params = [], $language = false)
 */
trait RecordsTrait
{
    use HasTypesRecordsTrait;
    use HasDatabaseConnectionTrait;
    use \Nip\Records\Traits\AbstractTrait\RecordsTrait;

    /**
     * @return mixed|Config
     * @throws Exception
     */
    protected function generateTable()
    {
        return config('payments.tables.' . PaymentsModels::METHODS, PaymentMethods::TABLE);
    }

    /**
     * @return string
     */
    public function getTypesDirectory()
    {
        return PaymentsServiceProvider::BASE_DIRECTORY
            . DIRECTORY_SEPARATOR . 'Models'
            . DIRECTORY_SEPARATOR . 'Methods'
            . DIRECTORY_SEPARATOR . 'Types';
    }

    /**
     * @return string
     */
    public function getTypeNamespace()
    {
        return '\Paytic\Payments\Models\Methods\Types\\';
    }
}
