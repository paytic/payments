<?php

namespace Paytic\Payments\PaymentMethods\Models\Traits;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordsTrait as HasTypesRecordsTrait;
use Paytic\Payments\PaymentsServiceProvider;

/**
 * Class RecordsTrait
 * @package Paytic\Payments\Models\Methods\Traits
 *
 * @method getMessage($name, $params = [], $language = false)
 */
trait RecordsTrait
{
    use HasTypesRecordsTrait;
    use \Nip\Records\Traits\AbstractTrait\RecordsTrait;

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
