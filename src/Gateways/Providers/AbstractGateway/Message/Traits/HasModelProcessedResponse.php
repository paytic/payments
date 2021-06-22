<?php

namespace ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits;

use ByTIC\Models\SmartProperties\RecordsTraits\HasStatus\RecordTrait;
use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use ByTIC\Payments\Models\Transactions\Statuses\Active;
use ByTIC\Payments\Models\Transactions\Statuses\Canceled;
use ByTIC\Payments\Models\Transactions\Statuses\Error;
use ByTIC\Payments\Models\Transactions\Statuses\Pending;
use Nip\Records\Record;

/**
 * Class HasView
 * @package ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits
 *
 */
trait HasModelProcessedResponse
{
    protected $modelResponseStatus = null;

    /**
     * @return $this
     */
    public function processModel()
    {
        if ($this->canProcessModel()) {
            $this->processModelStatus();
            $this->processModelData();
        }

        return $this;
    }

    /**
     * @return bool
     */
    protected function canProcessModel()
    {
        return false;
    }

    protected function processModelStatus()
    {
        $model = $this->getModel();
        $modelStatus = $this->getModel()->getStatus()->getName();
        $newModelStatus = $this->getModelResponseStatus();
        if (!$newModelStatus || $modelStatus === $newModelStatus) {
            return;
        }
        if ($modelStatus == 'active' && $newModelStatus == 'error') {
            // ignore error status after active received
            return;
        }
        if ($newModelStatus == 'active') {
            $model->received = $this->getTransactionDate();
        }
        $model->updateStatus($newModelStatus);
    }

    /**
     * @return Record|RecordTrait|IsPurchasableModelTrait
     */
    public function getModel()
    {
        return $this->getDataProperty('model');
    }

    /**
     * @return null|string
     */
    public function getModelResponseStatus(): ?string
    {
        if ($this->modelResponseStatus === null) {
            if ($this->isSuccessful()) {
                $status = Active::NAME;
            } elseif ($this->isCancelled()) {
                $status = Canceled::NAME;
            } elseif ($this->isPending()) {
                $status = Pending::NAME;
            } else {
                $status = Error::NAME;
            }
            $this->modelResponseStatus = $status;
        }

        return $this->modelResponseStatus;
    }

    /**
     * @return false|string
     */
    public function getTransactionDate()
    {
        if (is_callable('parent::getTransactionDate')) {
            /** @noinspection PhpUndefinedMethodInspection @phpstan-ignore-next-line */
            return parent::getTransactionDate();
        }
        return date('Y-m-d H:i:s');
    }

    public function processModelData()
    {
    }

    /**
     * @return bool
     */
    public function hasModel()
    {
        return is_object($this->getModel());
    }
}
