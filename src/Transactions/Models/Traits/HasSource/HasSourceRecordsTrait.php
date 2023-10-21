<?php

namespace Paytic\Payments\Transactions\Models\Traits\HasSource;

use Paytic\Payments\Transactions\SourceTypes\AbstractType;
use Paytic\Payments\Transactions\SourceTypes\Card;

/**
 *
 */
trait HasSourceRecordsTrait
{
    public function bootHasSourceRecordsTrait(): void
    {
        $this->registerSmartProperty('source_type', 'SourceType');
    }

    public function getSourceTypeItemsDirectory(): string
    {
        return AbstractType::BASE_PATH;
    }

    public function getSourceTypeItemsRootNamespace()
    {
        return 'Paytic\Payments\Transactions\SourceTypes';
    }

    public function getDefaultSourceType(): string
    {
        return Card::NAME;
    }
}