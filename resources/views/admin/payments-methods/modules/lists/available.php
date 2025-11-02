<?php

use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\Utility\PaymentsModels;

/** @var PaymentMethod[] $methods */
$methods = $this->availableMethods;
?>


<?php if (count($methods)) { ?>
    <div class="vstack gap-3 p-4">
        <?php foreach ($methods as $method) { ?>
            <form action="<?= PaymentsModels::methodLinks()->compileURL('add'); ?>"
                  class="form" style="">
                <input type="hidden" name="tenant" value="<?= $this->tenant->getManager()->getMorphName(); ?>"/>
                <input type="hidden" name="tenant_id" value="<?= $this->tenant->id; ?>"/>
                <input type="hidden" name="id_payment_method" value="<?= $method->id ?>"/>
                <button class="btn btn-info btn-xs btn-outline" style="text-align: center;">
                    <i class="fas fa-plus-circle"></i>
                    <?= $method->getName('internal'); ?>
                </button>
            </form>
        <?php } ?>
    </div>
<?php } else { ?>
    <?php echo $this->Messages()->error(PaymentsModels::methods()->getMessage('dnx')); ?>
<?php } ?>