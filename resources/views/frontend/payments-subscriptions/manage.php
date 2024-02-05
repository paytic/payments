<div class="d-grid my-6 gap-6">
    <?= $this->Flash()->render($this->controller); ?>

    <div class="subscription-header">
        <?= $this->load('/payments-subscriptions/modules/panels/item-header'); ?>
    </div>

    <div class="subscription-transactions">
        <?= $this->load('/payments-subscriptions/modules/panels/item-transactions'); ?>
    </div>
</div>