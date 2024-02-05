<?php


use ByTIC\Icons\Icons;
use Nip\Utility\Date;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Translations\BillingPeriodInWords;
use Paytic\Payments\Utility\PaymentsModels;

/** @var Subscription $item */
$item = $this->item;
$transaction = $item->getLastTransaction() ?? reset($this->transactions);
$amountHtml = $transaction->getAmountMoney()->formatByHtml();
?>
<?= $item->getStatusObject()->getLabelHTML(); ?>
<p class="fs-3">
    <?= $amountHtml; ?>
    <?= BillingPeriodInWords::for($item)->handle(); ?>
</p>

<?php if ($item->canBeCharged()) { ?>
    <?php $nextCharge = Date::parse($item->charge_at); ?>
    <p>
        <?= Icons::calendar() ?>
        <?= PaymentsModels::subscriptions()->getMessage(
            'dunning.next_charge',
            [
                'amount' => $amountHtml,
                'next' => $nextCharge->toFormattedDateString()
            ]
        ); ?>
    </p>
<?php } ?>
