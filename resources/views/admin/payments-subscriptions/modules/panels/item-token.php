<?php

use Paytic\Payments\Utility\PaymentsModels;

?>
<div class="card card-inverse">
    <div class="card-header">
        <h4 class="card-title">
            <?= PaymentsModels::tokens()->getLabel('title.singular'); ?>
        </h4>
    </div>
    <?= $this->load('/payments-tokens/modules/item/details', ['item' => $this->payment_token]); ?>
</div>