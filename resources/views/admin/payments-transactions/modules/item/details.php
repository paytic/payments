<?php

use Paytic\Payments\Models\Transactions\Statuses\Pending;
use Paytic\Payments\Models\Transactions\Transaction;
use Paytic\Payments\Utility\PaymentsModels;

$repository = PaymentsModels::transactions();

/** @var Transaction $item */
$item = $item ?? $this->transaction;
$statusesTransaction = $statuses ?? $item->getManager()->getStatuses();
$method = $item->getPaymentMethod();
$token = $item->getToken();
?>
<table class="table table-striped">
    <tbody>
    <tr>

    <tr>
        <td>
            <?= PaymentsModels::methods()->getLabel('title.singular'); ?>
        </td>
        <td>
            <?php if ($method) : ?>
                <a href="<?= $method->getURL(); ?>">
                    <?= $method->getName(); ?>
                </a>
            <?php else: ?>
                ---
            <?php endif; ?>
        </td>
    </tr>
    <tr>
        <td>
            <?= PaymentsModels::tokens()->getLabel('title.singular'); ?>
        </td>
        <td>
            <?php if ($token) : ?>
                <a href="<?= $token->getURL(); ?>">
                    <?= $token->getName(); ?>
                </a>
                <br/>
                EXP: <?= $token->expiration; ?>
            <?php else: ?>
                ---
            <?php endif; ?>
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
                        ['item' => $item, 'statuses' => $statusesTransaction]
                    ); ?>
                </div>
                <?php if ($item->isInStatus(Pending::NAME) && $token) : ?>
                    <div class="col">
                        <a href="<?= $item->compileURL('retry') ?>"
                           class="btn btn-xs btn-success pull-right">
                            Retry
                        </a>
                    </div>
                <?php endif; ?>
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