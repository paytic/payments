<?php

namespace Paytic\Payments\Bundle\Admin\Controllers;

use Nip\Records\AbstractModels\Record;
use Nip\Records\AbstractModels\RecordManager;
use Paytic\Payments\Models\Methods\PaymentMethod;
use Paytic\Payments\Models\Methods\Traits\RecordsTrait;
use Paytic\Payments\Models\Methods\Traits\RecordTrait;
use Paytic\Payments\PaymentMethods\Actions\FindPaymentMethodsForTenant;
use Paytic\Payments\Utility\PaymentsModels;

/**
 *
 */
trait PaymentsMethodsControllerTrait
{
    use AbstractControllerTrait;

    public function index(): void
    {
        $existingMethods = FindPaymentMethodsForTenant
            ::for($this->getPaymentTenant())
            ->fetch();

        $this->payload()->with([
            'items' => $existingMethods,
        ]);
    }


    public function addNewModel()
    {
        /** @var PaymentMethod $item */
        $item = parent::addNewModel();
        $item->populateFromTenant($this->getPaymentTenant());
        return $item;
    }

    public function deleteFile()
    {
        $item = $this->getModelFromRequest();
        $fileName = $this->getRequest()->get('file');

        $type = 'error';
        $message = $this->getModelManager()->getMessage('deleteFile.error');
        if ($fileName) {
            $files = $item->getFiles();
            if ($files[$fileName]) {
                $files[$fileName]->delete();
                $type = 'success';
                $message = $this->getModelManager()->getMessage('deleteFile.success');
            } else {
                $message = $this->getModelManager()->getMessage('deleteFile.no-file');
            }
        } else {
            $message = $this->getModelManager()->getMessage('deleteFile.no-filename');
        }
        $this->flashRedirect($message, $item->compileURL('view'), $type);
    }

    /**
     * @param PaymentMethod $item
     * @return bool
     */
    protected function checkItemAccess($item)
    {
        $methodTenant = $this->getPaymentTenant();
        $baseTenant = $item->getTenant();
        if ($methodTenant->getManager()->getController() != $baseTenant->getManager()->getController()) {
            return false;
        }
        if ($methodTenant->id != $baseTenant->id) {
            return false;
        }
        return true;
    }

    abstract protected function getPaymentTenant();

    /**
     * @param bool $key
     * @return Record|RecordTrait
     */
    abstract protected function getModelFromRequest($key = false);

    /**
     * @return RecordManager|RecordsTrait
     */
    abstract protected function getModelManager();

    public function delete()
    {
        $item = $this->getModelFromRequest();

        $deleteMessage = $item->canDelete();
        if ($deleteMessage !== true) {
            $url = $item->getURL();
            $this->_flashName = $this->getModelManager()->getController();
            $this->flashRedirect($deleteMessage, $url, 'error', $this->_flashName);
        }

        parent::delete();
    }

    protected function generateModelName(): string
    {
        return get_class(PaymentsModels::methods());
    }

}
