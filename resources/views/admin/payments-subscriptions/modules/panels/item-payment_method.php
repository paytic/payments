<?php

declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;

if (empty($this->payment_method)) {
    return;
}
?>
<div class="card card-inverse">
    <div class="card-header">
        <h4 class="card-title">
            <?= PaymentsModels::methods()->getLabel('title'); ?>
        </h4>
    </div>
    <?= $this->load('/payment_methods/modules/item/details', ['item' => $this->payment_method]); ?>
</div>