<?php

use ByTIC\AdminBase\Widgets\Cards\Card;
use ByTIC\Icons\Icons;
use Paytic\Payments\Utility\PaymentsModels;

$linksRepository = PaymentsModels::methodLinks();
?>
<?= $this->Flash()->render($this->controller); ?>

<div class="row">
    <div class="col-sm-9">
        <?php
        $card = Card::make()
                ->withTitle($linksRepository->getLabel('tenant.existing'))
                ->withIcon(Icons::list_ul())
                ->withView($this)
                ->withViewContent('/payments-methods_links/modules/lists/tenant')
                ->wrapBody(false);
        ?>
        <?= $card->render(); ?>
    </div>
    <div class="col-md-3">
        <?php
        $card = Card::make()
                ->withTitle($linksRepository->getLabel('tenant.available'))
                ->withIcon(Icons::list_ul())
                ->withView($this)
                ->withViewContent('/payments-methods/modules/lists/available');
        ?>
        <?= $card->render(); ?>
    </div>
</div>