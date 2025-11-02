<?php

use ByTIC\Icons\Icons;
use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\Utility\PaymentsModels;

/** @var PaymentMethod[] $methods */
$methods = $this->methodLinks;
?>
<?php if (count($methods)) { ?>
    <form action="" method="post">
        <table class="table table-bordered">
            <tbody>
            <?php foreach ($methods as $method) { ?>
                <tr>
                    <td>
                        <a href="<?= $method->getURL(); ?>" target="_blank">
                            <strong>
                                <?= $method->getName('internal'); ?>
                            </strong>
                        </a>
                    </td>
                    <td>
                        <div style="margin-bottom: 10px;">
                            <?php
                            $variations = [
                                    'visible' => [
                                            'name' => 'Vizibila',
                                            'class' => 'btn-success',
                                            'url' => $method->compileURL('eventActivate',
                                                    ['id_event' => $this->_event->id]),
                                    ],
                                    'hidden' => [
                                            'name' => 'Ascunsa',
                                            'class' => 'btn-light',
                                            'url' => $method->compileURL('eventDeactivate',
                                                    ['id_event' => $this->_event->id]),
                                    ],
                            ];
                            $selectedVisibility = $method->isVisible() ? 'visible' : 'hidden';
                            ?>
                            <!-- Single button -->
                            <div class="btn-group">
                                <?php
                                $class = $variations[$selectedVisibility]['class'];
                                ?>
                                <button type="button" class="btn btn-sm <?php echo $class; ?> dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $variations[$selectedVisibility]['name']; ?>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <?php foreach ($variations as $typeVariation => $variation) { ?>
                                        <li class="dropdown-item">
                                            <?php if ($typeVariation == $selectedVisibility) { ?>
                                                <a href="javascript:">
                                                    <strong>
                                                        <?php echo $variation['name']; ?>
                                                    </strong>
                                                </a>
                                            <?php } else { ?>
                                                <a href="<?php echo $variation['url']; ?>">
                                                    <?php echo $variation['name']; ?>
                                                </a>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <?php if ($method->isPrimary()) { ?>
                            <span class="badge bg-primary">
                                <?= $this->modelManager->getLabel('primary'); ?>
                            </span>
                        <?php } else { ?>
                            <a href="<?= $method->compileURL(
                                    'eventPrimary',
                                    ['id_event' => $this->_event->id]
                            ) ?>">
                                <small>
                                    <?= $this->modelManager->getLabel('primary.action'); ?>
                                </small>
                            </a>
                        <?php } ?>
                    </td>
                    <td>
                        <label><?= translator()->trans('notes'); ?></label>
                        <textarea name="method[<?= $method->id; ?>][notes]"
                                  style="width: 100%"
                        ><?= $method->__notes; ?></textarea>
                    </td>
                    <td>
                        <a href="<?= $this->_event->getPaymentMethodsURL([
                                '_trigger' => 'delete',
                                'id_payment_method' => $method->id,
                        ]); ?>"
                           class="btn btn-xs btn-danger float-end">
                            <?= Icons::remove() ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>

<?php } else { ?>
    <?= $this->Messages()->error(PaymentsModels::methodLinks()->getMessage('dnx.tenant')); ?>
<?php } ?>