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
        $class = $this->getMetadataClass();

        $this->addCast(
            'metadata',
            AsMetadataObject::class . ':json'
            . ($class ? ',' . $class : null)
        );
    }

    protected function getMetadataClass(): ?string
    {
        return null;
    }

    /**
     * @param $key
     * @param $value
     */
    public function setMedataValue($key, $value): void
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
