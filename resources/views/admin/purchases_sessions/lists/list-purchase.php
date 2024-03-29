<?php
/** @var PurchaseSessionTrait[] $sessions */

use Paytic\Payments\Models\PurchaseSessions\PurchaseSessionTrait;
use Paytic\Payments\Utility\PaymentsModels;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

$sessions_repository = PaymentsModels::sessions();

if (count($sessions) < 1) {
    echo $this->Messages()->info($sessions_repository->getMessage('dnx'));
    return;
}

$cloner = new VarCloner();
$dumper = new HtmlDumper();
?>
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
                foreach (['get', 'post', 'debug'] as $type) {
                    $rawData = print_r($sessions_repository::decodeParams($item->$type), true);
                    echo '<strong>' . strtoupper($type) . ':</strong>';
                    echo $dumper->dump($cloner->cloneVar($rawData), true);
                    echo '<hr/>';
                }
                ?>
            </td>

            <td><?php echo $item->created; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>