<?php

namespace Paytic\Payments\Gateways\Providers\AbstractGateway\Traits;

/**
 * Trait HasFormsTrait
 * @package Paytic\Payments\Gateways\Providers\AbstractGateway\Traits
 */
trait HasFormsTrait
{

    /**
     * @var Form
     */
    protected $form;


    /**
     * @return Form
     */
    public function getOptionsForm()
    {
        if (!$this->form) {
            $this->initOptionsForm();
        }

        return $this->form;
    }

    public function initOptionsForm()
    {
        $this->form = $this->newOptionsForm();
    }

    /**
     * @return Form
     */
    public function newOptionsForm()
    {
        $class = $this->getNamespacePath() . '\Form';
        $form = new $class();
        /** @var Form $form */
        $form->setGateway($this);

        return $form;
    }
}
