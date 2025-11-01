<?php

use Paytic\Payments\Utility\PaymentsModels;

?>
<?php if (count($this->organizer_methods)) { ?>
    <?php foreach ($this->organizer_methods as $method) { ?>
        <?php if (!isset($this->event_methods[$method->id])) { ?>
            <form action="" method="post" class="form" style="margin-bottom: 20px">
                <input type="hidden" name="_trigger" value="add"/>
                <input type="hidden" name="id_payment_method" value="<?php echo $method->id ?>"/>
                <button class="btn btn-info d-block" style="text-align: left; padding-left: 10px;">
                    <i class="fas fa-plus-circle"></i>
                    <?php echo $method->getName('internal'); ?>
                </button>
            </form>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <?php echo $this->Messages()->error(PaymentsModels::methods()->getMessage('dnx')); ?>
<?php } ?>