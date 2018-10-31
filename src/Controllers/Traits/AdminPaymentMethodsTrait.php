<?php

namespace ByTIC\Payments\Controllers\Traits;

use ByTIC\Common\Records\Record;
use ByTIC\Common\Records\Records;
use ByTIC\Payments\Models\Methods\Traits\RecordsTrait;
use ByTIC\Payments\Models\Methods\Traits\RecordTrait;
use Nip\Request;

/**
 * Class AdminPaymentMethodsTrait
 * @package ByTIC\Common\Payments\Controllers\Traits
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
            $files = $item->findFiles();
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
        $this->flashRedirect($message, $item->getViewURL(), $type);
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
     * @return Records|RecordsTrait
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
