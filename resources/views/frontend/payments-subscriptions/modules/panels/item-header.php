<?php

?>

<div class="p-5 bg-light">
    <?= $this->load('/payments-subscriptions/modules/item/title'); ?>
    <hr class="border-primary d-none d-md-block my-2 ms-3" style="">
    <div class="row">
        <div class="col-md-8 col-lg-9 col-xl-10">
            <?= $this->load('/payments-subscriptions/modules/item/details-text'); ?>
        </div>
        <div class="col-md-4 col-lg-3 col-xl-2">
            <?= $this->load('/payments-subscriptions/modules/item/actions'); ?>
        </div>
    </div>
</div>
