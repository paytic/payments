<?php

namespace Paytic\Payments\Controllers\Traits;

use Nip\Records\AbstractModels\Record;
use Nip\Records\AbstractModels\RecordManager;
use Paytic\Payments\Models\Methods\Traits\RecordsTrait;
use Paytic\Payments\Models\Methods\Traits\RecordTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminPaymentMethodsTrait
 * @package Paytic\Payments\Payments\Controllers\Traits
 */
trait AdminPaymentMethodsTrait
{
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
     * @param bool $key
     * @return Record|RecordTrait
     */
    abstract protected function getModelFromRequest($key = false);

    /**
     * @return Request
     */
    abstract protected function getRequest();

    /**
     * @return RecordManager|RecordsTrait
     */
    abstract protected function getModelManager();

    /**
     * @param $message
     * @param $url
     * @param string $type
     * @param bool $name
     * @return mixed
     */
    abstract protected function flashRedirect($message, $url, $type = 'success', $name = false);

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
}
