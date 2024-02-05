<?php


use ByTIC\Icons\Icons;
use Nip\Utility\Date;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Subscriptions\Actions\Translations\BillingPeriodInWords;
use Paytic\Payments\Utility\PaymentsModels;

/** @var Subscription $item */
$item = $this->item;

/** @var Transaction $lastTransaction */
$lastTransaction = $this->lastTransaction;
$amountHtml = $lastTransaction->getAmountMoney()->formatByHtml();
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
