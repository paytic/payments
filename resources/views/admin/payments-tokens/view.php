<div class="d-grid gap-6">
    <div class="row">
        <div class="col-md-4">
            <?= $this->load('modules/panels/item-details'); ?>
        </div>
        <div class="col-md-4">
            <div class="d-grid gap-6">
                <?= $this->load('modules/panels/item-organization'); ?>
                <?= $this->load('modules/panels/item-payment_method'); ?>
            </div>
        </div>
    </div>

    <?= $this->load('modules/panels/item-transactions'); ?>
</div>
