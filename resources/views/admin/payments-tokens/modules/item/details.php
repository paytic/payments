<?php declare(strict_types=1);

use Paytic\Payments\Models\Tokens\Token;
use Paytic\Payments\Utility\PaymentsModels;

/** @var Token $item */
$item ??= $this->item;
?>
<?php if (!($item instanceof Token)) : ?>
    <?= $this->Messages()->info(PaymentsModels::tokens()->getMessage('dnx')); ?>
    <?php return; ?>
<?php endif; ?>
<table class="details table table-striped">
    <tbody>
    <tr>
        <td class="name">
            <?= translator()->trans('name'); ?>:
        </td>
        <td class="value">
            <a href="<?= $item->getURL(); ?>">
                <?= $item->getName(); ?>
            </a>
        </td>
    </tr>
    <tr>
        <td class="name">
            <?= translator()->trans('expiration'); ?>:
        </td>
        <td class="value">
            <?= _strftime($item->expiration, '%a %d %b %Y, %H:%M:%S'); ?>
        </td>
    </tr>
    <tr>
        <td class="name">
            <?= translator()->trans('modified'); ?>:
        </td>
        <td class="value">
            <?= _strftime($item->modified, '%a %d %b %Y, %H:%M:%S'); ?>
        </td>
    </tr>
    <tr>
        <td class="name">
            <?= translator()->trans('created'); ?>:
        </td>
        <td class="value">
            <?= _strftime($item->created, '%a %d %b %Y, %H:%M:%S'); ?>
        </td>
    </tr>
    </tbody>
</table>