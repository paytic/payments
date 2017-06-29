<?php

namespace ByTIC\Payments\Models\Methods\Traits;

use ByTIC\Common\Records\Traits\HasTypes\RecordsTrait as HasTypesRecordsTrait;

/**
 * Class RecordsTrait
 * @package ByTIC\Payments\Models\Methods\Traits
 */
trait RecordsTrait
{
    use HasTypesRecordsTrait;

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
        return '\ByTIC\Payments\Models\Methods\Types\\';
    }
}
