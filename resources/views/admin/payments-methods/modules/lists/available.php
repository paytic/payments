<?php

use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\Utility\PaymentsModels;

/** @var PaymentMethod[] $methods */
$methods = $this->availableMethods;
$tenant = $this->payment_link_tenant;
?>


<?php if (count($methods)) { ?>
    <div class="d-grid gap-2">
        <?php foreach ($methods as $method) { ?>
            <?php
            $existingLink = $this->methodLinks->has($method->id);
            ?>
            <form action="<?= PaymentsModels::methodLinks()->compileURL('add'); ?>"
                  class="form" style="">
                <input type="hidden" name="tenant" value="<?= $tenant->getManager()->getMorphName(); ?>"/>
                <input type="hidden" name="tenant_id" value="<?= $tenant->id; ?>"/>
                <input type="hidden" name="id_payment_method" value="<?= $method->id ?>"/>
                <button class="btn btn-info w-100 btn-outline text-start"
                        <?= $existingLink ? 'disabled' : ''; ?>
                        style="text-align: center;">
                    <i class="fas fa-plus-circle"></i>
                    <?= $method->getName('internal'); ?>
                </button>
            </form>
        <?php } ?>
    </div>
<?php } else { ?>
    <?php echo $this->Messages()->error(PaymentsModels::methods()->getMessage('dnx')); ?>
<?php } ?>