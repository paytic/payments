<?php

use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Utility\PaymentsModels;

/** @var Subscription $item */
$item = $this->item;
?>
<h3 class="fw-semibold text-uppercase">
    <?= PaymentsModels::subscriptions()->getLabel('title.singular'); ?>
</h3>
