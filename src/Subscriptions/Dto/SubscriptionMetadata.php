<?php

namespace Paytic\Payments\Subscriptions\Dto;

use BackedEnum;
use ByTIC\DataObjects\Casts\Metadata\Metadata;
use Paytic\Payments\Subscriptions\Dto\Cancellation\CancellationTriggerEnum;

/**
 *
 */
class SubscriptionMetadata extends Metadata
{
    public const KEY_CANCELLATION = 'cancellation';

    public const KEY_CANCELLATION_TRIGGER = 'trigger';
    public const KEY_CANCELLATION_REASON = 'reason';
    public const KEY_CANCELLATION_COMMENT = 'comment';

    /**
     * @param $trigger
     * @return $this
     */
    public function setCancellationTrigger($trigger): static
    {
        if ($trigger instanceof CancellationTriggerEnum) {
            $trigger = $trigger->value;
        }
        $trigger = (string)$trigger;
        return $this->setCancellationItem(self::KEY_CANCELLATION_TRIGGER, $trigger);
    }

    public function getCancellationTrigger(): ?string
    {
        return $this->get(self::KEY_CANCELLATION . '.' . self::KEY_CANCELLATION_TRIGGER);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setCancellationItem($key, $value): static
    {
        $this->set(self::KEY_CANCELLATION . '.' . $key, $value);
        return $this;
    }

    /**
     * @param $reason
     * @return $this
     */
    public function setCancellationReason($reason): static
    {
        if ($reason instanceof BackedEnum) {
            $reason = $reason->value;
        }
        if (!is_array($reason)) {
            $reason = (string)$reason;
        }
        $reason = (string)$reason;
        return $this->setCancellationItem(self::KEY_CANCELLATION_REASON, $reason);
    }

    public function getCancellationReasonsArray(): array
    {
        $reasons = $this->get(self::KEY_CANCELLATION . '.' . self::KEY_CANCELLATION_REASON);
        if (is_array($reasons)) {
            return $reasons;
        }
        return explode(',', (string)$reasons);
    }

    /**
     * @param $comment
     * @return $this
     */
    public function setCancellationComment($comment): static
    {
        return $this->setCancellationItem(self::KEY_CANCELLATION_COMMENT, $comment);
    }

    /**
     * @return string|null
     */
    public function getCancellationComment(): ?string
    {
        return $this->get(self::KEY_CANCELLATION . '.' . self::KEY_CANCELLATION_COMMENT);
    }
}

