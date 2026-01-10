<?php

use Paytic\Payments\Utility\PaymentsModels;

$subscriptionsRepository = PaymentsModels::subscriptions();
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h1 class="fs-2 fw-bold mb-3 py-5">
                    <?= $subscriptionsRepository->getLabel('cancelled.title') ?>
                </h1>
                <?= $this->Messages()->success($subscriptionsRepository->getLabel('cancelled.confirmation')) ?>
                <p class="lead fs-5">
                    <?= $subscriptionsRepository->getLabel('cancelled.lead') ?>
                </p>
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5 mb-2 fw-bold">
                        <?= $subscriptionsRepository->getLabel('cancelled.form.title') ?>
                    </h2>
                    <p class="text-muted small mb-4">
                        <?= $subscriptionsRepository->getLabel('cancelled.form.subtitle') ?>
                    </p>
                    <?= $this->form; ?>
                </div>
            </div>
        </div>
    </div>
</div>