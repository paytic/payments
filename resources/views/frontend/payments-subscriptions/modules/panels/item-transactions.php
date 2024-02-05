<?php

use Paytic\Payments\Utility\PaymentsModels;

?>

<div class="p-5 bg-light">
    <h5 class="fw-semibold text-uppercase">
        <?= PaymentsModels::transactions()->getLabel('title.history'); ?>
    </h5>
    <hr class="border-primary" style="">
    <?= $this->load('/payments-transactions/modules/lists/subscription'); ?>
</div>
