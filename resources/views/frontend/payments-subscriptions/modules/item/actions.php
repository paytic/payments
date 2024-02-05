<?php


use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Urls\SubscriptionUrls;
use Paytic\Payments\Utility\PaymentsModels;

/** @var Subscription $item */
$item = $this->item;

$transaction = $item->getLastTransaction() ?? reset($this->transactions);
$amountHtml = $transaction->getAmountMoney()->formatByHtml();
$actionUrls = SubscriptionUrls::for($item);
?>

<?php if ($item->canBeCharged()) { ?>
    <div class="d-grid gap-6">
        <form name="" method="post" action="<?= $actionUrls->editUrl(); ?>"
              onsubmit="return confirm('<?= translator()->trans('general.messages.confirm'); ?>');"
              class="">
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-sm">
                    <?= PaymentsModels::subscriptions()->getLabel('btn.edit') ?>
                </button>
            </div>
        </form>
        <form name="" method="post" action=""
              onsubmit="return confirm('<?= translator()->trans('general.messages.confirm'); ?>');"
              class="">
            <div class="d-grid">
                <button type="submit" class="btn btn-danger btn-outline btn-sm">
                    <?= PaymentsModels::subscriptions()->getLabel('btn.cancel') ?>
                </button>
            </div>
        </form>
    </div>
<?php } ?>
