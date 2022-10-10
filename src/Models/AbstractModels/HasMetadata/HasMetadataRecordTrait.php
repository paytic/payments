<?php

namespace Paytic\Payments\Models\AbstractModels\HasMetadata;

use ByTIC\DataObjects\Casts\Metadata\AsMetadataObject;
use ByTIC\DataObjects\Casts\Metadata\Metadata;

/**
 * @property string|Metadata $metadata
 */
trait HasMetadataRecordTrait
{
    public function bootHasMetadataRecordTrait()
    {
        $this->addCast('metadata', AsMetadataObject::class . ':json');
    }

    /**
     * @param $key
     * @param $value
     */
    public function addMedataValue($key, $value): void
    {
        $this->metadata->set($key, $value);
    }

    /**
     * @param $key
     * @param $default
     * @return mixed
     */
    public function getMetadataValue($key, $default = null): mixed
    {
        return $this->metadata->get($key, $default);
    }
}
