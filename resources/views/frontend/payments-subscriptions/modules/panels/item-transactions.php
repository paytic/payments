<?php

use Paytic\Payments\Utility\PaymentsModels;

?>

<div class="p-5 bg-light">
    <h5>
        <?= PaymentsModels::transactions()->getLabel('title.history'); ?>
    </h5>
    <hr class="bg-primary" style="">
    <?= $this->load('/payments-transactions/modules/lists/subscription'); ?>
</div>
