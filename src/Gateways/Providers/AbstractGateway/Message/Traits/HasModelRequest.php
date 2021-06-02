<?php

namespace ByTIC\Payments\Gateways\Providers\AbstractGateway\Message\Traits;

use ByTIC\Payments\Models\Purchase\Traits\IsPurchasableModelTrait;
use Nip\Records\AbstractModels\Record;
use Nip\Records\AbstractModels\RecordManager;

/**
 * Class HasModelRequest
 * @package ByTIC\Common\Payments\Gateways\Providers\AbstractGateway\Message\Traits
 *
 * @property \Symfony\Component\HttpFoundation\Request $httpRequest
 */
trait HasModelRequest
{

    /**
     * @param  string $value
     * @return mixed
     */
    public function setModelManager($value)
    {
        return $this->setParameter('modelManager', $value);
    }

    /**
     * @return bool
     */
    protected function validateModel()
    {
        $model = $this->generateModelFromRequest();
        if ($this->isValidModel($model)) {
            $this->setModel($model);
            return true;
        }

        return false;
    }

    /**
     * @return bool|IsPurchasableModelTrait|Record
     */
    protected function generateModelFromRequest()
    {
        $model = $this->generateModelFromRequestBody();
        if ($this->isValidModel($model)) {
            return $model;
        } else {
            return $this->generateModelFromRequestQuery();
        }
    }

    /**
     * @return bool|IsPurchasableModelTrait|Record
     */
    protected function generateModelFromRequestBody()
    {
        $idModel = $this->getModelIdFromRequest();
        $id = intval($idModel);
        if (strlen($idModel) === strlen($id) && is_int($id) && $id > 0) {
            return $this->findModel($idModel);
        }
        return false;
    }

    /**
     * Returns ID if it has it
     * @return int
     */
    public function getModelIdFromRequest()
    {
        if (is_callable('parent::getModelIdFromRequest')) {
            /** @phpstan-ignore-next-line */
            return parent::getModelIdFromRequest();
        }
        return false;
    }

    /**
     * @param $id
     * @return IsPurchasableModelTrait|Record
     */
    protected function findModel($id)
    {
        return $this->getModelManager()->findOne($id);
    }

    /**
     * @return RecordManager
     */
    public function getModelManager()
    {
        return $this->getParameter('modelManager');
    }

    /**
     * @param $model
     * @return bool
     */
    protected function isValidModel($model)
    {
        return is_object($model);
    }

    /**
     * @return bool|IsPurchasableModelTrait
     */
    protected function generateModelFromRequestQuery()
    {
        $pkValue = $this->getModelPKFromRequestQuery();
        $field = $this->getModelUrlPkRequestKey();
        if ($pkValue) {
            return $this->findModelByField($field, $pkValue);
        }
        return false;
    }

    /**
     * returns key in confirm URL Query
     * @return int
     */
    public function getModelPKFromRequestQuery()
    {
        $modelKey = $this->getModelUrlPkRequestKey();

        return $this->getHttpRequest()->query->get($modelKey);
    }

    /**
     * @return string
     */
    public function getModelUrlPkRequestKey()
    {
        $modelIdMethod = 'getPaymentsUrlPK';
        if (method_exists($this->getModelManager(), $modelIdMethod)) {
            return $this->getModelManager()->$modelIdMethod();
        }

        return 'id';
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getHttpRequest()
    {
        return $this->httpRequest;
    }

    /**
     * @param $field
     * @param $value
     * @return IsPurchasableModelTrait
     */
    protected function findModelByField($field, $value)
    {
        if ($field == 'id') {
            return $this->findModel($value);
        }
        $method = 'findOneBy' . ucfirst($field);
        return $this->getModelManager()->$method($value);
    }

    /**
     * @param $model
     * @return $this
     */
    protected function setModel($model)
    {
        $this->setParameter('id', $model->id);
        $this->setParameter('model', $model);
        return $this;
    }

    /**
     * @param $idModel
     * @return bool
     */
    protected function setModelFromId($idModel)
    {
        $model = $this->findModel($idModel);
        if ($model) {
            $this->setModel($model);
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    protected function getModel()
    {
        return $this->getParameter('model');
    }

    /**
     * @inheritDoc
     */
    abstract protected function setParameter($key, $value);

    /**
     * @inheritDoc
     */
    abstract protected function getParameter($key);
}
