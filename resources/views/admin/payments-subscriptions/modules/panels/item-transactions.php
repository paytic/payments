<?php

use ByTIC\AdminBase\Widgets\Cards\Card;
use ByTIC\Icons\Icons;
use Paytic\Payments\Utility\PaymentsModels;

$repository = PaymentsModels::transactions();

/** @var $customer */
$items = $items ?? $this->transactions;

$card = Card::make()
    ->withView($this)
    ->withTitle($repository->getLabel('title'))
    ->withIcon(Icons::list_ul())
//    ->themeSuccess()
    ->wrapBody(false)
//    ->setHtmlAttribute('id', 'donations-panel')
    ->withViewContent(
        '/' . $repository->getController() . '/modules/lists/subscription',
        ['items' => $items]
    );
?>
<?= $card ?>