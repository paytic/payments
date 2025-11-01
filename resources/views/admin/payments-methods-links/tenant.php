<?php

use ByTIC\Icons\Icons; ?>
<?= $this->Flash()->render($this->controller); ?>

<div class="row">
    <div class="col-sm-9">
        <div class="card card-inverse">
            <div class="card-header">
                <h4 class="card-title">
                    <?= Icons::list_ul(); ?>
                    Existing methods
                </h4>
            </div>

            <?= $this->load('modules/lists/event-existing'); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-inverse">
            <div class="card-header">
                <h4 class="card-title">
                    <?= Icons::list_ul(); ?>
                    Add methods
                </h4>
            </div>
            <div class="card-body">

                <?= $this->load('modules/lists/event-available'); ?>
            </div>
        </div>
    </div>
</div>