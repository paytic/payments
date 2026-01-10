<?php

namespace Paytic\Payments\Subscriptions\Dto\Cancellation;

/**
 *
 */
interface CancellationReasonEnumInterface
{
    public const REASON_INTENT_ERROR = 'intent_error';
    public const REASON_FINANCIAL_HARDSHIP = 'financial_hardship';
    public const REASON_SWITCHED_SERVICE = 'switched_service';
    public const REASON_MISSING_FEATURES = 'missing_features';
    public const REASON_LOW_QUALITY = 'low_quality';
    public const REASON_TEMPORARY = 'temporary';
    public const REASON_OTHER = 'other';


    public static function values(): array;

    public static function labels(): array;

    public function label(): string;
}