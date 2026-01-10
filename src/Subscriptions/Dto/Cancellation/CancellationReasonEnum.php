<?php

namespace Paytic\Payments\Subscriptions\Dto\Cancellation;

/**
 *
 */
enum CancellationReasonEnum: string implements CancellationReasonEnumInterface
{
    use CancellationReasonTrait;

    case INTENT_ERROR = self::REASON_INTENT_ERROR;
    case FINANCIAL_HARDSHIP = self::REASON_FINANCIAL_HARDSHIP;
    case SWITCHED_SERVICE = self::REASON_SWITCHED_SERVICE;
    case MISSING_FEATURES = self::REASON_MISSING_FEATURES;
    case LOW_QUALITY = self::REASON_LOW_QUALITY;
    case TEMPORARY = self::REASON_TEMPORARY;
    case OTHER = self::REASON_OTHER;
}