<?php
/** @var \ByTIC\Payments\Models\PurchaseSessions\PurchaseSessionTrait[] $sessions */
$sessions_repository = \ByTIC\Payments\Utility\PaymentsModels::sessions();
?>
<?php if (count($sessions) < 1) { ?>
    <?php echo $this->Messages()->info($sessions_repository->getMessage('dnx')); ?>
<?php } ?>
<table class="table table-striped table-bordered donation-sessions">
    <thead>
    <tr>
        <th><?php echo app('payments.gateways')->getLabel('title.singular'); ?></th>
        <th><?php echo translator()->trans('type'); ?></th>
        <th><?php echo 'new status'; ?></th>
        <th><?php echo 'DATA'; ?></th>
        <th><?php echo translator()->trans('date'); ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($sessions as $item) { ?>
        <tr class="donation-session" id="session-<?php echo $item->id ?>">
            <td>
                <?php echo $item->gateway; ?>
            </td>
            <td><?php echo $item->type; ?></td>
            <td><?php echo $item->new_status; ?></td>
            <td>
                <?php
                foreach (['get', 'post', 'deug'] as $type) {
                    $rawData = print_r($sessions_repository::decodeParams($item->$type), true);
                    echo '<pre>' . $rawData . '</pre>';
                    echo '<hr/>';
                }
                ?>
            </td>

            <td><?php echo $item->created; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>