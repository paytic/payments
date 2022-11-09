<?php

use ByTIC\AdminBase\Screen\Actions\Dto\ButtonAction;
use ByTIC\AdminBase\Widgets\Cards\Card;
use ByTIC\Icons\Icons;
use Galantom\Forms\Library\Records\Locator\ModelLocator;
use Paytic\Payments\Models\Subscriptions\Subscription;
use Paytic\Payments\Utility\PaymentsModels;

/** @var Subscription $item */
$item = $item ?? $this->item;

$subscriptionsRepository = PaymentsModels::subscriptions();
$card = Card::make()
    ->withView($this)
    ->withTitle($subscriptionsRepository->getLabel('title.singular'))
    ->withIcon(Icons::list_ul())
//    ->addHeaderTool(
//        ButtonAction::make()
//            ->setUrl(
//                $item->compileURL('view',)
//            )
//            ->addHtmlClass('btn-xs')
//            ->setLabel(translator()->trans('view'))
//    )
//    ->themeSuccess()
    ->wrapBody(false)
//    ->setHtmlAttribute('id', 'donations-panel')
    ->withViewContent('/payments-subscriptions/modules/item/details', ['item' => $this->item]);
?>
<?= $card ?>