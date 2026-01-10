<?php

namespace Paytic\Payments\Subscriptions\Dto\Cancellation;

/**
 *
 */
enum CancellationTriggerEnum: string
{
    case USER_SELF = 'user_self';
    case USER_REQUEST = 'user_request';
    case SYSTEM_OVERDUE = 'system_overdue';
}
