<?php

namespace Paytic\Payments\Transactions\Models\Traits\HasSource;

/**
 *
 */
trait HasSourceRecordTrait
{
    public function getSourceTypeObject()
    {
        return $this->getSmartProperty('SourceType');
    }

    public function getSmartPropertyValueFromDefinition($definition)
    {
        $field = $definition->getField();
        if ($field !== 'source_type') {
            return $this->getSmartPropertyValueFromDefinitionRecordTrait($definition);
        }

        $value = $this->getSourceType();
        if (empty($value)) {
            $value = $definition->getDefaultValue();
            $this->setSourceType($value);
        }

        return $value;
    }

    /**
     * @return mixed
     */
    public function getSourceType()
    {
        return $this->getMetadataValue('source_type');
    }

    public function setSourceType($value)
    {
        $this->setMedataValue('source_type', $value);
    }
}