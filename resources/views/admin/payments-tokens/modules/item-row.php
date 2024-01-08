<?php declare(strict_types=1);

use Paytic\Payments\Models\Tokens\Token;

/** @var Token $item */
$payment_method = $item->getPaymentMethod();

?>
<tr>
    <td>
        <a href="<?= $item->getURL(); ?>" title="" class="form-link">
            <?= $item->getName(); ?>
        </a>
    </td>
    <td>
        <?php if ($payment_method) { ?>
            <a href="<?= $payment_method->getURL(); ?>" title="">
                <?= $payment_method->getName(); ?>
            </a>
        <?php } else { ?>
            ---
        <?php } ?>
    </td>
    <td>
        <?= $item->gateway; ?>
    </td>
    <td>
    </td>
    <td>
        <?= $item->expiration; ?>
    </td>
    <td>
        <?= $item->modified; ?>
    </td>
    <td>
        <?= $item->created; ?>
    </td>
</tr>