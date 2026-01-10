<?php

namespace Paytic\Payments\Subscriptions\Dto\Cancellation;

use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait CancellationReasonTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        $values = self::cases();
        $labels = [];
        foreach ($values as $value) {
            $labels[$value->value] = $value->label();
        }
        return $labels;
    }

    public function label(): string
    {
        return PaymentsModels::subscriptions()->getLabel('cancelled.reason.' . $this->value);
    }
}