<?php

use Paytic\Payments\Models\Subscriptions\Subscription;

/** @var Subscription $item */
$item = $item ?? $this->subscription;
$itemMetadata = $item->getMetadataObject();
?>
<table class="table table-striped">
    <tbody>
    <tr>
        <td>
            Cancellation
        </td>
        <td>
            Trigger: <?= $itemMetadata->getCancellationTrigger() ?>
            <br/>
            Reasons: <?= implode(', ', $itemMetadata->getCancellationReasonsArray()) ?>
            <br/>
            Comment: <?= $itemMetadata->getCancellationComment() ?>
        </td>
    </tr>
    </tbody>
</table>
