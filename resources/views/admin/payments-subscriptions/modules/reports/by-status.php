<?php

/** @var AbstractStatus[] $statuses */

use ByTIC\AdminBase\Widgets\Cards\Card;
use Paytic\Payments\Subscriptions\Statuses\AbstractStatus;

$statuses = $this->statuses ?? [];
?>
<div class="row">
    <?php foreach ($statuses as $status) { ?>
        <?php
        $card = Card::make()
            ->withView($this)
            ->withTitle($status->getLabel())
            ->withContent('<span>' . $status->count . '</span>');
        ?>
        <div class="col">
            <?= $card; ?>
        </div>
    <?php } ?>
</div>
