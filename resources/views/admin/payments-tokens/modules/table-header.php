<?php declare(strict_types=1);

use Paytic\Payments\Utility\PaymentsModels;

?>
<thead>
<tr>
    <th>
        <?= translator()->trans('name'); ?>
    </th>
    <th>
        <?= PaymentsModels::methods()->getLabel('title.singular'); ?>
    </th>
    <th>
        Gateway
    </th>
    <th>
        Customer
    </th>
    <th>
        <?= translator()->trans('expiration'); ?>
    </th>
    <th><?= translator()->trans('created'); ?></th>
    <th><?= translator()->trans('modified'); ?></th>
</tr>
</thead>
