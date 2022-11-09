<?php

use Paytic\Payments\Utility\PaymentsModels;

$repository = PaymentsModels::subscriptions();
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
            <?= $repository->getLabel('billing'); ?>
        </td>
        <td>
            <?= $item->billing_interval; ?>
            <?= $item->billing_period; ?>
        </td>
    </tr>
    <tr>
        <td>
            <?= $repository->getLabel('charge'); ?>
        </td>
        <td>
            <?= $item->charge_at; ?>
        </td>
    </tr>
    </tbody>
</table>