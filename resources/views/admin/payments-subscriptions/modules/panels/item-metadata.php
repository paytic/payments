<?php

use ByTIC\AdminBase\Widgets\Cards\Card;
use ByTIC\Icons\Icons;
use Paytic\Payments\Utility\PaymentsModels;

$repository = PaymentsModels::transactions();

/** @var $customer */
$items = $items ?? $this->transactions;

$card = Card::make()
    ->withView($this)
    ->withTitle('Metadata')
    ->withIcon(Icons::list_ul())
//    ->themeSuccess()
    ->wrapBody(false)
//    ->setHtmlAttribute('id', 'donations-panel')
    ->withViewContent(
        '/payments-subscriptions/modules/item/metadata',
    );
?>
<?= $card ?>