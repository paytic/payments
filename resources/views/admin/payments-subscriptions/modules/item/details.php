<?php

use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Subscriptions\Actions\Charges\ChargeIsDue;
use Paytic\Payments\Utility\PaymentsModels;

$repository = PaymentsModels::subscriptions();

/** @var Subscription $item */
$item = $item ?? $this->subscription;
?>
<table class="table table-striped">
    <tbody>
    <tr>
        <td>
            <?= translator()->trans('date'); ?>
        </td>
        <td>
            <div class="row">
                <div class="col">
                    <strong class="d-block text-muted">START</strong>
                    <?= $item->start_at; ?>
                </div>
                <div class="col">
                    <strong class="d-block text-muted">STOP</strong>
                    <?= $item->cancel_at; ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?= $repository->getLabel('recurring'); ?>
        </td>
        <td>
            <div class="row row-cols-2">
                <div class="col">
                    <span class="d-block text-muted">
                        <?= $repository->getLabel('interval'); ?>
                    </span>
                    <strong>
                        <?= $item->billing_interval; ?>
                        <?= $item->billing_period; ?>
                    </strong>
                </div>
                <div class="col">
                    <span class="d-block text-muted">NEXT</span>
                    <strong><?= $item->charge_at; ?></strong>
                </div>
                <div class="col">
                    <span class="d-block text-muted">ATTEMPTS</span>
                    <strong><?= $item->charge_attempts; ?></strong>
                </div>
                <div class="col">
                    <span class="d-block text-muted">CHARGES</span>
                    <strong><?= $item->charge_count; ?></strong>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?= $repository->getLabel('status'); ?>
        </td>
        <td>

            <div class="row">
                <div class="col">
                    <?= $this->load(
                        '/abstract/modules/item-actions/status-change',
                        ['item' => $item, 'statuses' => $this->statuses]
                    ); ?>
                </div>
                <div class="col">
                    <?php if (ChargeIsDue::for($item)) { ?>
                        <a href="<?= $item->compileURL('attemptCharge') ?>"
                           class="btn btn-xs btn-success pull-right">
                            Try to charge
                        </a>
                    <?php } ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?= translator()->trans('date'); ?>
        </td>
        <td>
            <div class="row">
                <div class="col">
                    <span class="d-block text-muted">UPDATED</span>
                    <strong><?= $item->modified; ?></strong>
                </div>
                <div class="col">
                    <span class="d-block text-muted">CREATED</span>
                    <strong><?= $item->created; ?></strong>
                </div>
            </div>
        </td>
    </tr>
    </tbody>
</table>