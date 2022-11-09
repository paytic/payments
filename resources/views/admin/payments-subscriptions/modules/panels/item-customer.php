<?php

use ByTIC\AdminBase\Screen\Actions\Dto\ButtonAction;
use ByTIC\AdminBase\Widgets\Cards\Card;
use ByTIC\Icons\Icons;
use Galantom\Forms\Library\Records\Locator\ModelLocator;
use Galantom\Forms\Models\OrgSupporters\OrgSupporter;

/** @var OrgSupporter $customer */
$customer = $item ?? $this->customer;
$customerRepository = $customer->getManager();

$card = Card::make()
    ->withView($this)
    ->withTitle($customerRepository->getLabel('title'))
    ->withIcon(Icons::list_ul())
    ->addHeaderTool(
        ButtonAction::make()
            ->setUrl(
                $customer->compileURL('view')
            )
            ->addHtmlClass('btn-xs')
            ->setLabel(translator()->trans('view'))
    )
//    ->themeSuccess()
    ->wrapBody(false)
//    ->setHtmlAttribute('id', 'donations-panel')
    ->withViewContent(
        '/' . $customerRepository->getController() . '/modules/item/details',
        ['item' => $customer]
    );
?>
<?= $card ?>