<?php
$this->addTab("details", "Detalii", "/" . $this->controller . "/modules/item-form",
    ["action" => $this->item->getUpdateURL()], true);
echo $this->load('/abstract/view');
