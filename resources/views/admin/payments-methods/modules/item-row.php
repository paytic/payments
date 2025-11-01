<?php
/** @var PaymentMethod $item */

use Paytic\Payments\Models\Methods\PaymentMethod;

?>
<tr>
    <td>
        <a href="<?= $item->getURL(); ?>" title="">
            <?= $item->getName('internal'); ?>
        </a>
    </td>
    <td>
        <a href="<?= $item->getURL(); ?>" title="">
            <?= $item->getName(); ?>
        </a>
    </td>
    <td><?= $item->getType()->getLabel(); ?></td>
</tr>