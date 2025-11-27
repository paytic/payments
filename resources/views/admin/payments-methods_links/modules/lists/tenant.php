<?php

use ByTIC\Icons\Icons;
use Paytic\Payments\MethodLinks\Models\PaymentMethodLink;
use Paytic\Payments\Utility\PaymentsModels;

/** @var PaymentMethodLink[] $methodLinks */
$methodLinks = $this->methodLinks;
$methodLinksRepository = PaymentsModels::methodLinks();
?>
<?php if (count($methodLinks)) { ?>
    <form action="" method="post">
        <table class="table table-bordered">
            <tbody>
            <?php foreach ($methodLinks as $methodLink) { ?>
                <?php
                $method = $methodLink->getPaymentMethod();

                $variations = [
                        'visible' => [
                                'name' => 'Vizibila',
                                'class' => 'btn-success',
                                'url' => $methodLink->compileURL('activate'),
                        ],
                        'hidden' => [
                                'name' => 'Ascunsa',
                                'class' => 'btn-light',
                                'url' => $methodLink->compileURL('deactivate'),
                        ],
                ];
                $selectedVisibility = $methodLink->isVisible() ? 'visible' : 'hidden';

                $class = $variations[$selectedVisibility]['class'];
                ?>
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
                            <!-- Single button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm <?php echo $class; ?> dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?= $variations[$selectedVisibility]['name']; ?>
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
                                                <a href="<?= $variation['url']; ?>">
                                                    <?= $variation['name']; ?>
                                                </a>
                                            <?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>

                        <?php if ($methodLink->isPrimary()) { ?>
                            <span class="badge bg-primary">
                                <?= $this->modelManager->getLabel('primary'); ?>
                            </span>
                        <?php } else { ?>
                            <a href="<?= $methodLink->compileURL('primary') ?>">
                                <small>
                                    <?= $this->modelManager->getLabel('primary.action'); ?>
                                </small>
                            </a>
                        <?php } ?>
                    </td>
                    <td>
                        <label><?= translator()->trans('notes'); ?></label>
                        <textarea name="methods[<?= $methodLink->id; ?>][notes]"
                                  style="width: 100%"
                        ><?= $methodLink->getNotes(); ?></textarea>
                    </td>
                    <td>
                        <a href="<?= $methodLink->compileURL('delete'); ?>"
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