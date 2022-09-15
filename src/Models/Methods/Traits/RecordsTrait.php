<?php

namespace Paytic\Payments\Models\Methods\Traits;

use ByTIC\Models\SmartProperties\RecordsTraits\HasTypes\RecordsTrait as HasTypesRecordsTrait;

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
        return dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Types';
    }

    /**
     * @return string
     */
    public function getTypeNamespace()
    {
        return '\Paytic\Payments\Models\Methods\Types\\';
    }
}
